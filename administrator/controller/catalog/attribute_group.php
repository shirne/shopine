<?php 
class ControllerCatalogAttributeGroup extends Controller { 
	private $error = array();
   
  	public function index() {
		$this->load_language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
		
    	$this->getList();
  	}
              
  	public function insert() {
		$this->load_language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_catalog_attribute_group->addAttributeGroup($this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
						
      		$this->redirect($this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
		$this->load_language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	  		$this->model_catalog_attribute_group->editAttributeGroup($this->request->get['attribute_group_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function delete() {
		$this->load_language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attribute_group_id) {
				$this->model_catalog_attribute_group->deleteAttributeGroup($attribute_group_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
				
		$url = $this->url->buildQuery($this->request->get,'sort,order,page');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		$this->data['insert'] = $this->url->link('catalog/attribute_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/attribute_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['attribute_groups'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$attribute_group_total = $this->model_catalog_attribute_group->getTotalAttributeGroups();
	
		$results = $this->model_catalog_attribute_group->getAttributeGroups($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/attribute_group/update', 'token=' . $this->session->data['token'] . '&attribute_group_id=' . $result['attribute_group_id'] . $url, 'SSL')
			);
						
			$this->data['attribute_groups'][] = array(
				'attribute_group_id' => $result['attribute_group_id'],
				'name'               => $result['name'],
				'sort_order'         => $result['sort_order'],
				'selected'           => isset($this->request->post['selected']) && in_array($result['attribute_group_id'], $this->request->post['selected']),
				'action'             => $action
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
		
		$this->data['sort_name'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . '&sort=agd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . '&sort=ag.sort_order' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,'sort,order');

		$pagination = new Pagination();
		$pagination->total = $attribute_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/attribute_group_list.tpl';
		
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
			'href'      => $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['attribute_group_id'])) {
			$this->data['action'] = $this->url->link('catalog/attribute_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/attribute_group/update', 'token=' . $this->session->data['token'] . '&attribute_group_id=' . $this->request->get['attribute_group_id'] . $url, 'SSL');
		}
			
		$this->data['cancel'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['attribute_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$attribute_group_info = $this->model_catalog_attribute_group->getAttributeGroup($this->request->get['attribute_group_id']);
		}
				
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['attribute_group_description'])) {
			$this->data['attribute_group_description'] = $this->request->post['attribute_group_description'];
		} elseif (isset($this->request->get['attribute_group_id'])) {
			$this->data['attribute_group_description'] = $this->model_catalog_attribute_group->getAttributeGroupDescriptions($this->request->get['attribute_group_id']);
		} else {
			$this->data['attribute_group_description'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($attribute_group_info)) {
			$this->data['sort_order'] = $attribute_group_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		$this->template = 'catalog/attribute_group_form.tpl';

		$this->id = 'content';
		$this->layout = 'layout/default';
		
		$this->render();	
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['attribute_group_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$this->load->model('catalog/attribute');
		
		foreach ($this->request->post['selected'] as $attribute_group_id) {
			$attribute_total = $this->model_catalog_attribute->getTotalAttributesByAttributeGroupId($attribute_group_id);

			if ($attribute_total) {
				$this->error['warning'] = sprintf($this->language->get('error_attribute'), $attribute_total);
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