<?php  
class ControllerArticleDownload extends Controller {  
	private $error = array();
   
  	public function index() {
		$this->load_language('article/download');

    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('article/download');
		
    	$this->getList();
  	}
  	        
  	public function insert() {
		$this->load_language('article/download');
    
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('article/download');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['download']['tmp_name'])) {
				$filename = $this->request->files['download']['name'] . '.' . md5(rand());
				
				move_uploaded_file($this->request->files['download']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['download'] = $filename;
					$data['mask'] = $this->request->files['download']['name'];
				}
			}

			$this->model_catalog_download->addDownload(array_merge($this->request->post, $data));
   	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
		$this->load_language('article/download');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('article/download');
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['download']['tmp_name'])) {
				$filename = $this->request->files['download']['name'] . '.' . md5(rand());
				
				move_uploaded_file($this->request->files['download']['tmp_name'], DIR_DOWNLOAD . $filename);

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					$data['download'] = $filename;
					$data['mask'] = $this->request->files['download']['name'];
				}
			}
			
			$this->model_catalog_download->editDownload($this->request->get['download_id'], array_merge($this->request->post, $data));
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	      
			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
    	$this->getForm();
  	}

  	public function delete() {
		$this->load_language('article/download');
 
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('article/download');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {	  
			foreach ($this->request->post['selected'] as $download_id) {
			
				$results = $this->model_catalog_download->getDownload($download_id) ;
               
				$filename = $results['filename'];

				if (file_exists(DIR_DOWNLOAD . $filename)) {
					@unlink(DIR_DOWNLOAD . $filename);
				}
			
				$this->model_catalog_download->deleteDownload($download_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,'sort,order,page');
			
			$this->redirect($this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
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
			'href'      => $this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		$this->data['insert'] = $this->url->link('article/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('article/download/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['downloads'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$download_total = $this->model_catalog_download->getTotalDownloads();
	
		$results = $this->model_catalog_download->getDownloads($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('article/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $result['download_id'] . $url, 'SSL')
			);
						
			$this->data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'remaining'   => $result['remaining'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['download_id'], $this->request->post['selected']),
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
		
		$this->data['sort_name'] = $this->url->link('article/download', 'token=' . $this->session->data['token'] . '&sort=dd.name' . $url, 'SSL');
		$this->data['sort_remaining'] = $this->url->link('article/download', 'token=' . $this->session->data['token'] . '&sort=d.remaining' . $url, 'SSL');
		
		$url = $this->url->buildQuery($this->request->get,'sort,order');

		$pagination = new Pagination();
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('article/download', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'article/download_list.tpl';
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
		
  		if (isset($this->error['download'])) {
			$this->data['error_download'] = $this->error['download'];
		} else {
			$this->data['error_download'] = '';
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
			'href'      => $this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL'),      		
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
							
		if (!isset($this->request->get['download_id'])) {
			$this->data['action'] = $this->url->link('article/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('article/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('article/download', 'token=' . $this->session->data['token'] . $url, 'SSL');
 		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

    	if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$download_info = $this->model_catalog_download->getDownload($this->request->get['download_id']);
    	}

    	if (isset($download_info['filename'])) {
    		$this->data['filename'] = $download_info['filename'];
		} else {
			$this->data['filename'] = '';
		}
    	  
    	if (isset($this->request->get['download_id'])) {
    		$this->data['show_update'] = true;
		} else {
			$this->data['show_update'] = false;
 		}

		if (isset($this->request->post['download_description'])) {
			$this->data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$this->data['download_description'] = $this->model_catalog_download->getDownloadDescriptions($this->request->get['download_id']);
		} else {
			$this->data['download_description'] = array();
		}   	
		
		if (isset($this->request->post['remaining'])) {
      		$this->data['remaining'] = $this->request->post['remaining'];
    	} elseif (isset($download_info['remaining'])) {
      		$this->data['remaining'] = $download_info['remaining'];
    	} else {
      		$this->data['remaining'] = 1;
    	}
    	
    	if (isset($this->request->post['update'])) {
      		$this->data['update'] = $this->request->post['update'];
    	} else {
      		$this->data['update'] = false;
    	}

		$this->template = 'article/download_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();	
  	}

  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'article/download')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['download_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name'])) > 64)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}	

		if ($this->request->files['download']['name']) {
			if ((strlen(utf8_decode($this->request->files['download']['name'])) < 1) || (strlen(utf8_decode($this->request->files['download']['name'])) > 128)) {
        		$this->error['download'] = $this->language->get('error_filename');
	  		}	  	
			
			if (substr(strrchr($this->request->files['download']['name'], '.'), 1) == 'php') {
       	   		$this->error['download'] = $this->language->get('error_filetype');
       		}	
						
			if ($this->request->files['download']['error'] != UPLOAD_ERR_OK) {
				$this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['download']['error']);
			}
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'article/download')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
		
		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $download_id) {
  			$product_total = $this->model_catalog_product->getTotalProductsByDownloadId($download_id);
    
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
}
?>