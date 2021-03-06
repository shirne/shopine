<?php 
class ControllerDesignFlink extends Controller {
	private $error = array();
 
	public function index() {
		$this->load_language('design/flink');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/flink');
		
		$this->getList();
	}

	public function insert() {
		$this->load_language('design/flink');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/flink');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_flink->addFlink($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load_language('design/flink');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/flink');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_flink->editFlink($this->request->get['flink_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

					
			$this->redirect($this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load_language('design/flink');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/flink');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $flink_id) {
				$this->model_design_flink->deleteFlink($flink_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');


			$this->redirect($this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$url = $this->url->buildQuery($this->request->get,"sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		$this->data['insert'] = $this->url->link('design/flink/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/flink/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['flinks'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$flink_total = $this->model_design_flink->getTotalFlinks();
		
		$results = $this->model_design_flink->getFlinks($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/flink/update', 'token=' . $this->session->data['token'] . '&flink_id=' . $result['flink_id'] . $url, 'SSL')
			);

			$this->data['flinks'][] = array(
				'flink_id' => $result['flink_id'],
				'name'      => $result['name'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['flink_id'], $this->request->post['selected']),				
				'action'    => $action
			);
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = $this->url->link('design/flink', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('design/flink', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,"sort,order");

		$pagination = new Pagination();
		$pagination->total = $flink_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/flink_list.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
	}

	private function getForm() {
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

 		if (isset($this->error['flink_site'])) {
			$this->data['error_flink_site'] = $this->error['flink_site'];
		} else {
			$this->data['error_flink_site'] = array();
		}	
						
		$url = $this->url->buildQuery($this->request->get,"sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		if (!isset($this->request->get['flink_id'])) { 
			$this->data['action'] = $this->url->link('design/flink/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/flink/update', 'token=' . $this->session->data['token'] . '&flink_id=' . $this->request->get['flink_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('design/flink', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->get['flink_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$flink_info = $this->model_design_flink->getFlink($this->request->get['flink_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($flink_info)) {
			$this->data['name'] = $flink_info['name'];
		} else {
			$this->data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($flink_info)) {
			$this->data['status'] = $flink_info['status'];
		} else {
			$this->data['status'] = true;
		}

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
	
		if (isset($this->request->post['flink_site'])) {
			$flink_sites = $this->request->post['flink_site'];
		} elseif (isset($flink_info)) {
			$flink_sites = $this->model_design_flink->getFlinkImages($this->request->get['flink_id']);	
		} else {
			$flink_sites = array();
		}
		
		$this->data['flink_sites'] = array();
		
		foreach ($flink_sites as $flink_site) {
			if ($flink_site['image'] && file_exists(DIR_IMAGE . $flink_site['image'])) {
				$image = $flink_site['image'];
			} else {
				$image = 'no_image.jpg';
			}			
			
			$this->data['flink_sites'][] = array(
				'flink_site_description' => $flink_site['flink_site_description'],
				'link'                     => $flink_site['link'],
				'image'                    => $image,
				'preview'                  => $this->model_tool_image->resize($image, 100, 100)
			);	
		} 
	
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);		

		$this->template = 'design/flink_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/flink')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 1) || (strlen(utf8_decode($this->request->post['name'])) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (isset($this->request->post['flink_site'])) {
			foreach ($this->request->post['flink_site'] as $flink_site_id => $flink_site) {
				foreach ($flink_site['flink_site_description'] as $language_id => $flink_site_description) {
					if ((strlen(utf8_decode($flink_site_description['title'])) < 2) || (strlen(utf8_decode($flink_site_description['title'])) > 64)) {
						$this->error['flink_site'][$flink_site_id][$language_id] = $this->language->get('error_title'); 
					}					
				}
			}	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/flink')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>