<?php 
class ControllerCatalogAttribute extends Controller { 
	private $error = array();
   
  	public function index() {
		$this->load_language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
    	$this->getList();
  	}
              
  	public function insert() {
		$this->load_language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_catalog_attribute->addAttribute($this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
						
      		$this->redirect($this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
		$this->load_language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	  		$this->model_catalog_attribute->editAttribute($this->request->get['attribute_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function delete() {
		$this->load_language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attribute_id) {
				$this->model_catalog_attribute->deleteAttribute($attribute_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
  	}
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ad.name';
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
				
		$url = $this->url->buildQuery($this->request->get,'sort,order,page');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		$this->data['insert'] = $this->url->link('catalog/attribute/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/attribute/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['attributes'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$attribute_total = $this->model_catalog_attribute->getTotalAttributes();
	
		$results = $this->model_catalog_attribute->getAttributes($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/attribute/update', 'token=' . $this->session->data['token'] . '&attribute_id=' . $result['attribute_id'] . $url, 'SSL')
			);
						
			$this->data['attributes'][] = array(
				'attribute_id'    => $result['attribute_id'],
				'name'            => $result['name'],
				'attribute_group' => $result['attribute_group'],
				'sort_order'      => $result['sort_order'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['attribute_id'], $this->request->post['selected']),
				'action'          => $action
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
		
		$this->data['sort_name'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=ad.name' . $url, 'SSL');
		$this->data['sort_attribute_group'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=attribute_group' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=a.sort_order' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,'sort,order');

		$pagination = new Pagination();
		$pagination->total = $attribute_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/attribute_list.tpl';
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
		
		$url = $this->url->buildQuery($this->request->get,'sort,order,page');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['attribute_id'])) {
			$this->data['action'] = $this->url->link('catalog/attribute/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/attribute/update', 'token=' . $this->session->data['token'] . '&attribute_id=' . $this->request->get['attribute_id'] . $url, 'SSL');
		}
			
		$this->data['cancel'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['attribute_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($this->request->get['attribute_id']);
		}
				
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['attribute_description'])) {
			$this->data['attribute_description'] = $this->request->post['attribute_description'];
		} elseif (isset($this->request->get['attribute_id'])) {
			$this->data['attribute_description'] = $this->model_catalog_attribute->getAttributeDescriptions($this->request->get['attribute_id']);
		} else {
			$this->data['attribute_description'] = array();
		}

		if (isset($this->request->post['attribute_group_id'])) {
			$this->data['attribute_group_id'] = $this->request->post['attribute_group_id'];
		} elseif (isset($attribute_info)) {
			$this->data['attribute_group_id'] = $attribute_info['attribute_group_id'];
		} else {
			$this->data['attribute_group_id'] = '';
		}
		
		$this->load->model('catalog/attribute_group');
				
		$this->data['attribute_groups'] = $this->model_catalog_attribute_group->getAttributeGroups();	

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($attribute_info)) {
			$this->data['sort_order'] = $attribute_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		$this->template = 'catalog/attribute_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		
		$this->render();
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['attribute_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name'])) > 64)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$this->load->model('catalog/product');
		
		foreach ($this->request->post['selected'] as $attribute_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByAttributeId($attribute_id);

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
			$this->load->model('catalog/attribute');
			
			$data = array(
				'filter_name' => $this->request->post['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$json = array();
			
			$results = $this->model_catalog_attribute->getAttributes($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'attribute_id'    => $result['attribute_id'], 
					'name'            => $result['name'],
					'attribute_group' => $result['attribute_group']
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