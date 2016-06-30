<?php  
class ControllerArticleArticle extends Controller {
	private $error = array(); 
	
	public function index() { 
		$this->load_language('article/article');
	
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		$this->load->model('article/category');	
		
		if (isset($this->request->get['path'])) {
			$path = '';
				
			foreach (explode('_', $this->request->get['path']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_article_category->getCategory($path_id);
				
				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('article/category', 'path=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		}
		
		if (isset($this->request->get['filter_title']) || isset($this->request->get['filter_tag'])) {
			$url=$this->url->buildQuery($this->request->get,'filter_title,filter_tag,filter_content,filter_category_id');
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('article/search', $url),
				'separator' => $this->language->get('text_separator')
			);	
		}
		
		if (isset($this->request->get['article_id'])) {
			$article_id = $this->request->get['article_id'];
		} else {
			$article_id = 0;
		}
		
		$this->load->model('article/article');
		
		$article_info = $this->model_article_article->getarticle($article_id);
		
		$this->data['article_info'] = $article_info;
		$this->data['share_link'] =  $this->url->link('common/home');
		if ($article_info) {
			$url=$this->url->buildQuery($this->request->get,'path,filter_title,filter_tag,filter_content,filter_category_id');
												
			$this->data['breadcrumbs'][] = array(
				'text'      => $article_info['title'],
				'href'      => $this->url->link('article/article', $url . '&article_id=' . $this->request->get['article_id']),
				'separator' => $this->language->get('text_separator')
			);			
			
			if(isset($article_info['meta_title']))
				$this->document->setTitle($article_info['meta_title']!=''?$article_info['meta_title']:$article_info['title']);
			else
				$this->document->setTitle($article_info['title']);
			$this->document->setDescription($article_info['meta_description']);
			$this->document->setKeywords($article_info['meta_keyword']);
			$this->document->addLink($this->url->link('article/article', 'article_id=' . $this->request->get['article_id']), 'canonical');
			
			$this->data['share_link'] =$this->url->link('article/article', 'article_id=' . $this->request->get['article_id']);
			$this->data['heading_title'] = $article_info['title'];
			
			
			$this->data['article_id'] = $this->request->get['article_id'];
			
			$this->load->model('tool/image');

			$this->data['image_thumb_width'] = $this->config->get('config_image_thumb_width');
			$this->data['image_thumb_height'] = $this->config->get('config_image_thumb_height');
			
			if ($article_info['image']) {
				$this->data['popup'] = $this->model_tool_image->resize($article_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$this->data['popup'] = '';
			}
			
			if ($article_info['image']) {
				$this->data['big'] = $this->model_tool_image->resize($article_info['image'],768, 1024);
			} else {
				$this->data['big'] = '';
			}
			
			if ($article_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($article_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));;
			}
			
			if ($article_info['image']) {
				$this->data['small'] = $this->model_tool_image->resize($article_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
			} else {
				$this->data['small'] = '';
			}
			
			$this->data['articles'] = array();
			
			$results = $this->model_article_article->getArticleRelated($this->request->get['article_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}
							
				$this->data['articles'][] = array(
					'article_id' => $result['article_id'],
					'thumb'   	 => $image,
					'title'    	 => $result['title'],
					'href'    	 => $this->url->link('article/article', 'article_id=' . $result['article_id']),
				);
			}	
			
			$this->data['tags'] = array();
					
			$results = $this->model_article_article->getArticleTags($this->request->get['article_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag'  => $result['tag'],
					'href' => $this->url->link('article/search', 'filter_tag=' . $result['tag'])
				);
			}
			
			
			$this->model_article_article->updateViewed($this->request->get['article_id']);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/article/article.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/article/article.tpl';
			} else {
				$this->template = 'default/template/article/article.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
			
		} else {

			$url=$this->url->buildQuery($this->request->get,'path,filter_title,filter_tag,filter_content,filter_category_id');
								
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('article/article', $url . '&article_id=' . $article_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
    	}
  	}
}
?>