<?php
class ControllerCatalogOption extends Controller {
	private $error = array();  
 
	public function index() {
		$this->load_language('catalog/option');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/option');
		
		$this->getList();
	}

	public function insert() {
		$this->load_language('catalog/option');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/option');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_option->addOption($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load_language('catalog/option');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/option');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_option->editOption($this->request->get['option_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load_language('catalog/option');

		$this->document->setTitle($this->language->get('heading_title'));
 		
		$this->load->model('catalog/option');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $option_id) {
				$this->model_catalog_option->deleteOption($option_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
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
			'href'      => $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		$this->data['insert'] = $this->url->link('catalog/option/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/option/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['options'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$option_total = $this->model_catalog_option->getTotalOptions();
		
		$results = $this->model_catalog_option->getOptions($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/option/update', 'token=' . $this->session->data['token'] . '&option_id=' . $result['option_id'] . $url, 'SSL')
			);

			$this->data['options'][] = array(
				'option_id'  => $result['option_id'],
				'fixed'       => $result['fixed'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']),
				'action'     => $action
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
		
		$this->data['sort_name'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,"sort,order");

		$pagination = new Pagination();
		$pagination->total = $option_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/option_list.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
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
			$this->data['error_name'] = array();
		}	
				
 		if (isset($this->error['option_value'])) {
			$this->data['error_option_value'] = $this->error['option_value'];
		} else {
			$this->data['error_option_value'] = array();
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
			'href'      => $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['option_id'])) {
			$this->data['action'] = $this->url->link('catalog/option/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else { 
			$this->data['action'] = $this->url->link('catalog/option/update', 'token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['option_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$option_info = $this->model_catalog_option->getOption($this->request->get['option_id']);
    	}

    	$this->data['options']=$this->model_catalog_option->getOptions();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['option_description'])) {
			$this->data['option_description'] = $this->request->post['option_description'];
		} elseif (isset($this->request->get['option_id'])) {
			$this->data['option_description'] = $this->model_catalog_option->getOptionDescriptions($this->request->get['option_id']);
		} else {
			$this->data['option_description'] = array();
		}

		if (isset($this->request->post['fixed'])) {
			$this->data['fixed'] = $this->request->post['fixed'];
		} elseif (isset($option_info)) {
			$this->data['fixed'] = $option_info['fixed'];
		} else {
			$this->data['fixed'] = '';
		}

		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (isset($option_info)) {
			$this->data['type'] = $option_info['type'];
		} else {
			$this->data['type'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($option_info)) {
			$this->data['sort_order'] = $option_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		if (isset($this->request->post['option_value'])) {
			$this->data['option_values'] = $this->request->post['option_value'];
		} elseif (isset($this->request->get['option_id'])) {
			$this->data['option_values'] = $this->model_catalog_option->getOptionValueDescriptions($this->request->get['option_id']);
		} else {
			$this->data['option_values'] = array();
		}

		$this->template = 'catalog/option_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/option')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['option_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name'])) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['option_value'])) {
			$this->error['warning'] = $this->language->get('error_type');
		}

		if (isset($this->request->post['option_value'])) {
			foreach ($this->request->post['option_value'] as $option_value_id => $option_value) {
				foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
					if ((strlen(utf8_decode($option_value_description['name'])) < 1) || (strlen(utf8_decode($option_value_description['name'])) > 128)) {
						$this->error['option_value'][$option_value_id][$language_id] = $this->language->get('error_option_value'); 
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
		if (!$this->user->hasPermission('modify', 'catalog/option')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('catalog/product');
		
		foreach ($this->request->post['selected'] as $option_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByOptionId($option_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->post['filter_name'])) {
			$this->load_language('catalog/option');
			
			$this->load->model('catalog/option');
			
			$data = array(
				'filter_name' => $this->request->post['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$options = $this->model_catalog_option->getOptions($data);
			
			foreach ($options as $option) {
				$option_value_data = array();
				
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
					$option_values = $this->model_catalog_option->getOptionValues($option['option_id']);
					
					foreach ($option_values as $option_value) {
						$option_value_data[] = array(
							'option_value_id' => $option_value['option_value_id'],
							'name'            => html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8')					
						);
					}
					
					$sort_order = array();
				  
					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}
			
					array_multisort($sort_order, SORT_ASC, $option_value_data);					
				}
				
				$type = '';
				
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
					$type = $this->language->get('text_choose');
				}
				
				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}
				
				if ($option['type'] == 'file') {
					$type = $this->language->get('text_file');
				}
				
				if ($option['type'] == 'color') {
					$type = $this->language->get('text_color');
				}
				
				if ($option['type'] == 'virtual_product') {
					$type = $this->language->get('text_virtual_product');
				}
				
				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = $this->language->get('text_date');
				}
												
				$json[] = array(
					'option_id'    => $option['option_id'],
					'name'         => html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8'),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
				);
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
				
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
}
?>