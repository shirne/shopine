<?php 
class ControllerArticleSearch extends Controller { 	
	public function index() { 
    	$this->load_language('article/search');
		
		$this->load->model('article/category');
		
		$this->load->model('article/article');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = '';
		} 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_content'])) {
			$filter_content = $this->request->get['filter_content'];
		} else {
			$filter_content = '';
		} 
				
		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
		} 
								
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
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
				
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['keyword']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);

   		$url = $this->url->buildQuery($this->request->get,'filter_title,filter_tag,filter_content,filter_category_id,filter_sub_category,sort,order,page,limit');
						
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('article/search', $url),
      		'separator' => $this->language->get('text_separator')
   		);
		
   		
		$this->load->model('article/category');
		
		// 3 Level Category Search
		$this->data['categories'] = array();
					
		$categories_1 = $this->model_article_category->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_article_category->getCategories($category_1['article_category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_article_category->getCategories($category_2['article_category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['article_category_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'category_id' => $category_2['article_category_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$this->data['categories'][] = array(
				'category_id' => $category_1['article_category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
		
		$this->data['articles'] = array();
		
		if (isset($this->request->get['filter_title']) || isset($this->request->get['filter_tag'])) {
			$data = array(
				'filter_title'         => $filter_title, 
				'filter_tag'          => $filter_tag, 
				'filter_content'  	  => $filter_content,
				'filter_category_id'  => $filter_category_id, 
				'filter_sub_category' => $filter_sub_category, 
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);
					
			$article_total = $this->model_article_article->getTotalArticles($data);
								
			$results = $this->model_article_article->getArticles($data);
					
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_article_width'), $this->config->get('config_image_article_height'));
				} else {
					$image = false;
				}
				
				$this->data['articles'][] = array(
					'article_id'  => $result['article_id'],
					'thumb'       => $image,
					'title'        => $result['title'],
					//'description' => substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'content' => truncate(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')), 200) . '..',
					'href'        => $this->url->link('article/article', $url . '&article_id=' . $result['article_id'])
				);
			}

			$url = $this->url->buildQuery($this->request->get,'filter_title,filter_tag,filter_content,filter_category_id,filter_sub_category,limit');
						
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('article/search', 'sort=p.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_title_asc'),
				'value' => 'p.title-ASC',
				'href'  => $this->url->link('article/search', 'sort=p.title&order=ASC' . $url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_title_desc'),
				'value' => 'p.title-DESC',
				'href'  => $this->url->link('article/search', 'sort=p.title&order=DESC' . $url)
			);
		
			$url = $this->url->buildQuery($this->request->get,'filter_title,filter_tag,filter_content,filter_category_id,filter_sub_category,sort,order');
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('article/search', $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('article/search', $url . '&limit=25')
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('article/search', $url . '&limit=50')
			);
	
			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('article/search', $url . '&limit=75')
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('article/search', $url . '&limit=100')
			);

			$url = $this->url->buildQuery($this->request->get,'filter_title,filter_tag,filter_content,filter_category_id,filter_sub_category,sort,order,limit');
					
			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('article/search', $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();
		}	
		
		$this->data['filter_title'] = $filter_title;
		$this->data['filter_content'] = $filter_content;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_sub_category'] = $filter_sub_category;
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/article/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/article/search.tpl';
		} else {
			$this->template = 'default/template/article/search.tpl';
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
?>