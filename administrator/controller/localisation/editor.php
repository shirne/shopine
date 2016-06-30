<?php 
class ControllerLocalisationEditor extends Controller {
	private $error = array();
  
	public function index() {
		$this->load_language('localisation/editor');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/editor');
		
		$this->getList();
	}

	public function insert() {
		$this->load_language('localisation/editor');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/editor');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_editor->addEditor($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load_language('localisation/editor');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/editor');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_editor->editEditor($this->request->get['editor_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"sort,order,page");
					
			$this->redirect($this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load_language('localisation/editor');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/editor');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $editor_id) {
				$this->model_localisation_editor->deleteEditor($editor_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');


			$this->redirect($this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
   		   	'text'      => $this->language->get('heading_title_1'),
   		   	'href'      => $this->url->link('setting/parameter', 'token=' . $this->session->data['token'], 'SSL'),
   		   	'separator' => $this->language->get('text_breadcrumb_separator')
   		);
   		 
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
	
		$this->data['insert'] = $this->url->link('localisation/editor/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/editor/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
	
		$this->data['editors'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$editor_total = $this->model_localisation_editor->getTotalEditors();
		
		$results = $this->model_localisation_editor->getEditors($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('localisation/editor/update', 'token=' . $this->session->data['token'] . '&editor_id=' . $result['editor_id'] . $url, 'SSL')
			);
					
			$this->data['editors'][] = array(
				'editor_id' => $result['editor_id'],
				'name'        => $result['name'] . (($result['code'] == $this->config->get('config_editor')) ? $this->language->get('text_default') : null),
				'code'        => $result['code'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['editor_id'], $this->request->post['selected']),
				'action'      => $action	
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
					
		$this->data['sort_name'] = $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . '&sort=code' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = $this->url->buildQuery($this->request->get,"sort,order");
				
		$pagination = new Pagination();
		$pagination->total = $editor_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/editor_list.tpl';
		$this->id = 'content';
		$this->layout = 'layout/parameter';
		$this->render();
	}

	private function getForm() {
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

 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
 		if (isset($this->error['locale'])) {
			$this->data['error_locale'] = $this->error['locale'];
		} else {
			$this->data['error_locale'] = '';
		}		
		
 		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
		}	
		
 		if (isset($this->error['directory'])) {
			$this->data['error_directory'] = $this->error['directory'];
		} else {
			$this->data['error_directory'] = '';
		}
		
		$url = $this->url->buildQuery($this->request->get,"sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);
   		
   		$this->data['breadcrumbs'][] = array(
   		   	'text'      => $this->language->get('heading_title_1'),
   		   	'href'      => $this->url->link('setting/parameter', 'token=' . $this->session->data['token'], 'SSL'),
   		   	'separator' => $this->language->get('text_breadcrumb_separator')
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL'),      		
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['editor_id'])) {
			$this->data['action'] = $this->url->link('localisation/editor/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/editor/update', 'token=' . $this->session->data['token'] . '&editor_id=' . $this->request->get['editor_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('localisation/editor', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['editor_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$editor_info = $this->model_localisation_editor->getEditor($this->request->get['editor_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($editor_info)) {
			$this->data['name'] = $editor_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (isset($editor_info)) {
			$this->data['code'] = $editor_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['locale'])) {
			$this->data['locale'] = $this->request->post['locale'];
		} elseif (isset($editor_info)) {
			$this->data['locale'] = $editor_info['locale'];
		} else {
			$this->data['locale'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($editor_info)) {
			$this->data['image'] = $editor_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['directory'])) {
			$this->data['directory'] = $this->request->post['directory'];
		} elseif (isset($editor_info)) {
			$this->data['directory'] = $editor_info['directory'];
		} else {
			$this->data['directory'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($editor_info)) {
			$this->data['sort_order'] = $editor_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($editor_info)) {
			$this->data['status'] = $editor_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

		$this->template = 'localisation/editor_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/parameter';
		$this->render();
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/editor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 1) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (strlen(utf8_decode($this->request->post['code'])) < 2) {
			$this->error['code'] = $this->language->get('error_code');
		}
		
		if (!$this->request->post['directory']) { 
			$this->error['directory'] = $this->language->get('error_directory'); 
		}
		
		if ((strlen(utf8_decode($this->request->post['image'])) < 1) || (strlen(utf8_decode($this->request->post['image'])) > 32)) {
			$this->error['image'] = $this->language->get('error_image');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/editor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		
		$this->load->model('setting/store');
		$this->load->model('sale/order');
		
		foreach ($this->request->post['selected'] as $editor_id) {
			$editor_info = $this->model_localisation_editor->getEditor($editor_id);

			if ($editor_info) {
				if ($this->config->get('config_editor') == $editor_info['code']) {
					$this->error['warning'] = $this->language->get('error_default');
				}
				
				if ($this->config->get('config_admin_editor') == $editor_info['code']) {
					$this->error['warning'] = $this->language->get('error_admin');
				}
			}	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
}
?>