<?php 
class ControllerLocalisationReturnReason extends Controller { 
	private $error = array();
   
  	public function index() {
		$this->load_language('localisation/return_reason');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/return_reason');
		
    	$this->getList();
  	}
              
  	public function insert() {
		$this->load_language('localisation/return_reason');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/return_reason');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_localisation_return_reason->addReturnReason($this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

						
      		$this->redirect($this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
		$this->load_language('localisation/return_reason');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/return_reason');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	  		$this->model_localisation_return_reason->editReturnReason($this->request->get['return_reason_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function delete() {
		$this->load_language('localisation/return_reason');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('localisation/return_reason');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $return_reason_id) {
				$this->model_localisation_return_reason->deleteReturnReason($return_reason_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		$this->data['insert'] = $this->url->link('localisation/return_reason/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/return_reason/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['return_reasons'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$return_reason_total = $this->model_localisation_return_reason->getTotalReturnReasons();
	
		$results = $this->model_localisation_return_reason->getReturnReasons($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('localisation/return_reason/update', 'token=' . $this->session->data['token'] . '&return_reason_id=' . $result['return_reason_id'] . $url, 'SSL')
			);
						
			$this->data['return_reasons'][] = array(
				'return_reason_id' => $result['return_reason_id'],
				'name'          => $result['name'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['return_reason_id'], $this->request->post['selected']),
				'action'        => $action
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
		
		$this->data['sort_name'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,"sort,order");

		$pagination = new Pagination();
		$pagination->total = $return_reason_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/return_reason_list.tpl';
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
			$this->data['error_name'] = array();
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
			'href'      => $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['return_reason_id'])) {
			$this->data['action'] = $this->url->link('localisation/return_reason/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/return_reason/update', 'token=' . $this->session->data['token'] . '&return_reason_id=' . $this->request->get['return_reason_id'] . $url, 'SSL');
		}
			
		$this->data['cancel'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['return_reason'])) {
			$this->data['return_reason'] = $this->request->post['return_reason'];
		} elseif (isset($this->request->get['return_reason_id'])) {
			$this->data['return_reason'] = $this->model_localisation_return_reason->getReturnReasonDescriptions($this->request->get['return_reason_id']);
		} else {
			$this->data['return_reason'] = array();
		}

		$this->template = 'localisation/return_reason_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/parameter';
		$this->render();
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'localisation/return_reason')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['return_reason'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name'])) > 32)) {
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
		if (!$this->user->hasPermission('modify', 'localisation/return_reason')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$this->load->model('sale/return');
		
		foreach ($this->request->post['selected'] as $return_reason_id) {
			$return_total = $this->model_sale_return->getTotalReturnProductsByReturnReasonId($return_reason_id);
		
			if ($return_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_return'), $return_total);	
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