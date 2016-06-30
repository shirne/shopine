<?php 
class ControllerCatalogInformationCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load_language('catalog/information_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/information_category');
		
		$this->getList();
	}

	public function insert() {
		$this->load_language('catalog/information_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/information_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_information_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load_language('catalog/information_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/information_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_information_category->editCategory($this->request->get['information_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load_language('catalog/information_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/information_category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $information_category_id) {
				$this->model_catalog_information_category->deleteCategory($information_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
   		
   		$this->data['insert'] = $this->url->link('catalog/information_category/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('catalog/information_category/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['categories'] = array();
		
		$results = $this->model_catalog_information_category->getCategories(0);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/information_category/update', 'token=' . $this->session->data['token'] . '&information_category_id=' . $result['information_category_id'], 'SSL')
			);
			
			$action[] = array(
				'text' => $this->language->get('text_manage_information'),
				'href' => $this->url->link('catalog/information','&token=' . $this->session->data['token'] . '&filter_category_id=' . $result['information_category_id'], 'SSL')
			);
					
			$this->data['categories'][] = array(
				'information_category_id' => $result['information_category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['information_category_id'], $this->request->post['selected']),
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
		
		$this->template = 'catalog/information_category_list.tpl';
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

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
   		
   		if (!isset($this->request->get['information_category_id'])) {
			$this->data['action'] = $this->url->link('catalog/information_category/insert', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_add'),
				'href'      => $this->data['action'],
				'separator' => $this->language->get('text_breadcrumb_separator')
			);
   		} else {
			$this->data['action'] = $this->url->link('catalog/information_category/update', 'token=' . $this->session->data['token'] . '&information_category_id=' . $this->request->get['information_category_id'], 'SSL');
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_edit'),
				'href'      => $this->data['action'],
				'separator' => $this->language->get('text_breadcrumb_separator')
			);
		}
		
		$this->data['cancel'] = $this->url->link('catalog/information_category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['information_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->model_catalog_information_category->getCategory($this->request->get['information_category_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/editor');
		
		$this->data['editorinit'] = $this->model_localisation_editor->showEditor(
			$this->config->get('config_admin_editor'),
			array(
				'token'=>$this->session->data['token'],
				'language_code'=>$this->language->get('code')
			));

		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($category_info)) {
			$this->data['category_description'] = $this->model_catalog_information_category->getCategoryDescriptions($this->request->get['information_category_id']);
		} else {
			$this->data['category_description'] = array();
		}

		$categories = $this->model_catalog_information_category->getCategories(0);

		// Remove own id from list
		if (isset($category_info)) {
			foreach ($categories as $key => $information_category) {
				if ($information_category['information_category_id'] == $category_info['information_category_id']) {
					unset($categories[$key]);
				}
			}
		}

		$this->data['categories'] = $categories;

		$values=array(
			'parent_id' =>0,
			'sort_order' =>0
		);
		
		foreach ($values as $key => $value) {
			if (isset($this->request->post[$key])) {
				$this->data[$key] = $this->request->post[$key];
			} elseif (isset($category_info)) {
				$this->data[$key] = $category_info[$key];
			} else {
				$this->data[$key] = $value;
			}
		}
		
		$this->template = 'catalog/information_category_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
	}

	private function validateForm() {
		$rules=$this->load->rule();
		$this->load_language('error_msg');
		 
		if (!$this->user->hasPermission('modify', 'catalog/information_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] =  $this->language->get('error_name');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/information_category')) {
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