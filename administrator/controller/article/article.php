<?php
class ControllerArticleArticle extends Controller {
	private $error = array();

  	public function index() {
  		
		$this->load_language('article/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');
		
		$this->getList();
  	}

  	public function insert() {
    	$this->load_language('article/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_article_article->addArticle($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");
			
			$this->redirect($this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getForm();
  	}

  	public function update() {
    	$this->load_language('article/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSingleForm()) {
			$this->model_article_article->editArticle($this->request->get['article_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");

			$this->redirect($this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getSingleForm();
  	}

  	public function delete() {
    	$this->load_language('article/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_article_article->deleteArticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");
			
			$this->redirect($this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  	
  	public function changeStatus() {
    	$this->load_language('article/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');

		if (isset($this->request->post['selected']) ) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_article_article->updateArticleStatus($article_id,$this->request->get['status']);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");
			
			$this->redirect($this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}


  	public function copy() {
    	$this->load_language('article/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('article/article');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_article_article->copyArticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");

			$this->redirect($this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  	
  	private function getList() {
  		$requestes=array(
  		  	'filter_title' => null,
  			'filter_category_id' => null,
  		  	'filter_status' => null,
  		  	'filter_language_id'=>null,
  		  	'sort' => 'pd.title',
  		  	'order' => 'ASC',
  		  	'page' => 1
  		);
  			
  		foreach ($requestes as $key => $value) {
  			if (isset($this->request->get[$key])) {
  				$$key = $this->request->get[$key];
  			} else {
  				$$key = $value;
  			}
  		}

		$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);

		$this->data['insert'] = $this->url->link('article/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('article/article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('article/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['enabled'] = $this->url->link('article/article/changeStatus', 'status=1&token=' . $this->session->data['token'], 'SSL');
		$this->data['disabled'] = $this->url->link('article/article/changeStatus', 'status=0&token=' . $this->session->data['token'], 'SSL');
		
		
		$this->data['articles'] = array();

		$data = array(
			'filter_title'	  => $filter_title,
			'filter_status'   => $filter_status,
			'filter_category_id' =>$filter_category_id,
			'filter_language_id'=>$filter_language_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');

		$article_total = $this->model_article_article->getTotalArticles($data);

		$results = $this->model_article_article->getArticles($data);
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('article/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $result['article_id'] . $url, 'SSL')
			);
			
			$preview=array(
				'text' => $this->language->get('text_preview'),
					'href' => HTTP_CATALOG.'index.php?route=article/article&article_id='. $result['article_id']
			);

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$this->data['articles'][$result['article_id']] = array(
				'article_id' => $result['article_id'],
				'title'       => $result['title'],
				'image'      => $image,
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['article_id'], $this->request->post['selected']),
				'action'     => $action
			);
			
		}

    	$this->data['token'] = $this->session->data['token'];

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

		$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,page");

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		$this->data['sort_title'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . '&sort=pd.title' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
		$this->data['sort_category_id'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . '&sort=p.category_id' . $url, 'SSL');
		$url = '';

		$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order");

		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_title'] = $filter_title;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'article/article_list.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
  	}

  	private function article_setter($article_info,$key,$default=''){
  		if (isset($this->request->post[$key])) {
  			$this->data[$key] = $this->request->post[$key];
  		} elseif (isset($article_info)) {
  			$this->data[$key] = $article_info[$key];
  		} else {
  			$this->data[$key] = $default;
  		}
  	}

  	private function getSingleForm() {
  		$errores=array(
  			'warning' => '',
  			'title' => '',
  			'meta_description' =>'',
	  		'content' =>''
  		);
  		
  		$err_flag='error_';
  		foreach ($errores as $key => $value) {
	  		if (isset($this->error[$key])) {
				$this->data[$err_flag.$key] = $this->error[$key];
			} else {
				$this->data[$err_flag.$key] = $value;
			}
  		}
  		
		$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => false
   		);

		/*if (!isset($this->request->get['article_id'])) {
			$this->data['action'] = $this->url->link('article/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$this->data['breadcrumbs'][] = array(
			    'text'      => $this->language->get('text_add'),
				'href'      => $this->data['action'],
			    'separator' => $this->language->get('text_breadcrumb_separator')
			);
		} else {*/
			$this->data['action'] = $this->url->link('article/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $this->request->get['article_id'] . $url, 'SSL');
			$this->data['breadcrumbs'][] = array(
			    'text'      => $this->language->get('text_edit'),
				'href'      => $this->data['action'],
			    'separator' => $this->language->get('text_breadcrumb_separator')
			);
		//}

		$this->data['cancel'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		//if (isset($this->request->get['article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$article_info = $this->model_article_article->getArticle($this->request->get['article_id']);
    	//}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/editor');
		
		$this->data['editorinit'] = $this->model_localisation_editor->showEditor(
			$this->config->get('config_admin_editor'),
			array(
				'token'=>$this->session->data['token'],
				'language_code'=>$this->language->get('code')
			));

		if (isset($this->request->post['article'])) {
			$this->data['article'] = $this->request->post['article'];
		} elseif (isset($article_info)) {
			$this->data['article'] = $article_info;
		} else {
			$this->data['article'] = array();
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['article_store'])) {
			$this->data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($article_info)) {
			$this->data['article_store'] = $this->model_article_article->getArticleStores($this->request->get['article_id']);
		} else {
			$this->data['article_store'] = array(0);
		}
		

		$this->article_setter(isset($article_info)?$article_info : NULL, 'keyword');
		
		if (isset($this->request->post['article_tag'])) {
			$this->data['article_tag'] = $this->request->post['article_tag'];
		} elseif (isset($article_info)) {
			$this->data['article_tag'] = $this->model_article_article->getArticleTags($this->request->get['article_id']);
		} else {
			$this->data['article_tag'] = array();
		}

		$this->article_setter(isset($article_info)?$article_info : NULL, 'image');
		
		$this->load->model('tool/image');

		if (isset($article_info) && $article_info['image'] && file_exists(DIR_IMAGE . $article_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->article_setter(isset($article_info)?$article_info : NULL, 'sort_order',1);
		
		$this->load->model('localisation/stock_status');

		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

    	$this->article_setter(isset($article_info)?$article_info : NULL, 'status',1);
    	

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->load->model('article/download');

		$this->data['downloads'] = $this->model_article_download->getDownloads();

		if (isset($this->request->post['article_download'])) {
			$this->data['article_download'] = $this->request->post['article_download'];
		} elseif (isset($article_info)) {
			$this->data['article_download'] = $this->model_article_article->getArticleDownloads($this->request->get['article_id']);
		} else {
			$this->data['article_download'] = array();
		}

		$this->load->model('article/category');

		$this->data['categories'] = $this->model_article_category->getCategories(0);

		if (isset($this->request->post['article_category'])) {
			$this->data['article_category'] = $this->request->post['article_category'];
		} elseif (isset($article_info)) {
			$this->data['article_category'] = $this->model_article_article->getArticleCategories($this->request->get['article_id']);
		} else {
			$this->data['article_category'] = array();
		}

		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($article_info)) {
			$articles = $this->model_article_article->getArticleRelated($this->request->get['article_id']);
		} else {
			$articles = array();
		}

		$this->data['article_related'] = array();

		foreach ($articles as $article_id) {
			$related_info = $this->model_article_article->getArticle($article_id);

			if ($related_info) {
				$this->data['article_related'][] = array(
					'article_id' => $related_info['article_id'],
					'title'       => $related_info['title']
				);
			}
		}
		

		if (isset($this->request->post['article_layout'])) {
			$this->data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($article_info)) {
			$this->data['article_layout'] = $this->model_article_article->getArticleLayouts($this->request->get['article_id']);
		} else {
			$this->data['article_layout'] = array();
		}

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'article/article_single_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
  	}

  	private function validateSingleForm() {
  		$rules=$this->load->rule();
  		$this->load_language('error_msg');
    	
    	if (!$this->user->hasPermission('modify', 'article/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	/*foreach ($this->request->post['article_description'] as $language_id => $value) {
      		if ((utf8_strlen(utf8_decode($value['title'])) < $rules['str_lenth']) ) {
        		$this->error['title'][$language_id] = $this->language->get('error_title');
      		}
    	}*/
    	if ((utf8_strlen(utf8_decode($this->request->post['title'])) < $rules['str_lenth']) ) {
    		$this->error['title'] = $this->language->get('error_title');
  		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
  	
  	private function getForm() {
  		$errores=array(
  			'warning' => '',
  			'title' => array(),
  			'meta_description' =>array(),
	  		'content' =>array()
  		);
  		
  		$err_flag='error_';
  		foreach ($errores as $key => $value) {
	  		if (isset($this->error[$key])) {
				$this->data[$err_flag.$key] = $this->error[$key];
			} else {
				$this->data[$err_flag.$key] = $value;
			}
  		}
  		
		$url = $this->url->buildQuery($this->request->get,"filter_title,filter_status,filter_category_id,sort,order,page");

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => false
   		);

		//if (!isset($this->request->get['group_id'])) {
			$this->data['action'] = $this->url->link('article/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$this->data['breadcrumbs'][] = array(
			    'text'      => $this->language->get('text_add'),
				'href'      => $this->data['action'],
			    'separator' => $this->language->get('text_breadcrumb_separator')
			);
		/*} else {
			$this->data['action'] = $this->url->link('article/article/update', 'token=' . $this->session->data['token'] . '&group_id=' . $this->request->get['group_id'] . $url, 'SSL');
			$this->data['breadcrumbs'][] = array(
			    'text'      => $this->language->get('text_edit'),
				'href'      => $this->data['action'],
			    'separator' => $this->language->get('text_breadcrumb_separator')
			);
		}*/

		$this->data['cancel'] = $this->url->link('article/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		/*if (isset($this->request->get['group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$article_info = $this->model_article_article->getArticle($this->request->get['group_id']);
    	}*/

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/editor');
		
		$this->data['editorinit'] = $this->model_localisation_editor->showEditor(
			$this->config->get('config_admin_editor'),
			array(
				'token'=>$this->session->data['token'],
				'language_code'=>$this->language->get('code')
			));

		if (isset($this->request->post['article'])) {
			$this->data['article'] = $this->request->post['article'];
		/*} elseif (isset($article_info)) {
			$this->data['article'] = $this->model_article_article->getArticleDescriptions($this->request->get['article_id']);*/
		} else {
			$this->data['article'] = array();
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['article_store'])) {
			$this->data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($article_info)) {
			$this->data['article_store'] = $this->model_article_article->getArticleStores($this->request->get['article_id']);
		} else {
			$this->data['article_store'] = array(0);
		}
		

		$this->article_setter(isset($article_info)?$article_info : NULL, 'keyword');
		
		if (isset($this->request->post['article_tag'])) {
			$this->data['article_tag'] = $this->request->post['article_tag'];
		} elseif (isset($article_info)) {
			$this->data['article_tag'] = $this->model_article_article->getArticleTags($this->request->get['article_id']);
		} else {
			$this->data['article_tag'] = array();
		}

		$this->article_setter(isset($article_info)?$article_info : NULL, 'image');
		
		$this->load->model('tool/image');

		if (isset($article_info) && $article_info['image'] && file_exists(DIR_IMAGE . $article_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->article_setter(isset($article_info)?$article_info : NULL, 'sort_order',1);
		
		$this->load->model('localisation/stock_status');

		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

    	$this->article_setter(isset($article_info)?$article_info : NULL, 'status',1);
    	

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->load->model('article/download');

		$this->data['downloads'] = $this->model_article_download->getDownloads();

		if (isset($this->request->post['article_download'])) {
			$this->data['article_download'] = $this->request->post['article_download'];
		} elseif (isset($article_info)) {
			$this->data['article_download'] = $this->model_article_article->getArticleDownloads($this->request->get['article_id']);
		} else {
			$this->data['article_download'] = array();
		}

		$this->load->model('article/category');

		$this->data['categories'] = $this->model_article_category->getCategories(0);

		if (isset($this->request->post['article_category'])) {
			$this->data['article_category'] = $this->request->post['article_category'];
		} elseif (isset($article_info)) {
			$this->data['article_category'] = $this->model_article_article->getArticleCategories($this->request->get['article_id']);
		} else {
			$this->data['article_category'] = array();
		}

		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($article_info)) {
			$articles = $this->model_article_article->getArticleRelated($this->request->get['article_id']);
		} else {
			$articles = array();
		}

		$this->data['article_related'] = array();

		foreach ($articles as $article_id) {
			$related_info = $this->model_article_article->getArticle($article_id);

			if ($related_info) {
				$this->data['article_related'][] = array(
					'article_id' => $related_info['article_id'],
					'title'       => $related_info['title']
				);
			}
		}


		

		if (isset($this->request->post['article_layout'])) {
			$this->data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($article_info)) {
			$this->data['article_layout'] = $this->model_article_article->getArticleLayouts($this->request->get['article_id']);
		} else {
			$this->data['article_layout'] = array();
		}

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'article/article_form.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
  	}

  	private function validateForm() {
  		$rules=$this->load->rule();
  		$this->load_language('error_msg');
    	
    	if (!$this->user->hasPermission('modify', 'article/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	/*foreach ($this->request->post['article_description'] as $language_id => $value) {
      		if ((utf8_strlen(utf8_decode($value['title'])) < $rules['str_lenth']) ) {
        		$this->error['title'][$language_id] = $this->language->get('error_title');
      		}
    	}*/

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'article/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'article/article')) {
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