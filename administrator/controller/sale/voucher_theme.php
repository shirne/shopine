<?php 
class ControllerSaleVoucherTheme extends Controller { 
	private $error = array();
   
  	public function index() {
		$this->load_language('sale/voucher_theme');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/voucher_theme');
		
    	$this->getList();
  	}
              
  	public function insert() {
		$this->load_language('sale/voucher_theme');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/voucher_theme');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_sale_voucher_theme->addVoucherTheme($this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

						
      		$this->redirect($this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
		$this->load_language('sale/voucher_theme');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/voucher_theme');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	  		$this->model_sale_voucher_theme->editVoucherTheme($this->request->get['voucher_theme_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function delete() {
		$this->load_language('sale/voucher_theme');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/voucher_theme');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $voucher_theme_id) {
				$this->model_sale_voucher_theme->deleteVoucherTheme($voucher_theme_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');

			
			$this->redirect($this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
  	}
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'vtd.name';
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
			'href'      => $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		$this->data['insert'] = $this->url->link('sale/voucher_theme/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/voucher_theme/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['voucher_themes'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$voucher_theme_total = $this->model_sale_voucher_theme->getTotalVoucherThemes();
	
		$results = $this->model_sale_voucher_theme->getVoucherThemes($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/voucher_theme/update', 'token=' . $this->session->data['token'] . '&voucher_theme_id=' . $result['voucher_theme_id'] . $url, 'SSL')
			);
						
			$this->data['voucher_themes'][] = array(
				'voucher_theme_id' => $result['voucher_theme_id'],
				'name'             => $result['name'],
				'selected'         => isset($this->request->post['selected']) && in_array($result['voucher_theme_id'], $this->request->post['selected']),
				'action'           => $action
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
		
		$this->data['sort_name'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,"sort,order");

		$pagination = new Pagination();
		$pagination->total = $voucher_theme_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/voucher_theme_list.tpl';
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
		
 		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
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
			'href'      => $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		if (!isset($this->request->get['voucher_theme_id'])) {
			$this->data['action'] = $this->url->link('sale/voucher_theme/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/voucher_theme/update', 'token=' . $this->session->data['token'] . '&voucher_theme_id=' . $this->request->get['voucher_theme_id'] . $url, 'SSL');
		}
		
		if (isset($this->request->get['voucher_theme_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$voucher_theme_info = $this->model_sale_voucher_theme->getVoucherTheme($this->request->get['voucher_theme_id']);
    	}
					
		$this->data['cancel'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['voucher_theme_description'])) {
			$this->data['voucher_theme_description'] = $this->request->post['voucher_theme_description'];
		} elseif (isset($this->request->get['voucher_theme_id'])) {
			$this->data['voucher_theme_description'] = $this->model_sale_voucher_theme->getVoucherThemeDescriptions($this->request->get['voucher_theme_id']);
		} else {
			$this->data['voucher_theme_description'] = array();
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($voucher_theme_info)) {
			$this->data['image'] = $voucher_theme_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($voucher_theme_info) && $voucher_theme_info['image'] && file_exists(DIR_IMAGE . $voucher_theme_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($voucher_theme_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
				
		$this->template = 'sale/voucher_theme_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/voucher_theme')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['voucher_theme_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name'])) > 32)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
		if (!$this->request->post['image']) {
			$this->error['image'] = $this->language->get('error_image');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/voucher_theme')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$this->load->model('sale/voucher');
		
		foreach ($this->request->post['selected'] as $voucher_theme_id) {
			$voucher_total = $this->model_sale_voucher->getTotalVouchersByVoucherThemeId($voucher_theme_id);
		
			if ($voucher_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_voucher'), $voucher_total);	
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