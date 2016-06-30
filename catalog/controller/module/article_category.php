<?php  
class ControllerModuleArticleCategory extends Controller {
	protected function index() {
		$this->language->load('module/article_category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['article_category_id'] = $parts[0];
		} else {
			$this->data['article_category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('article/category');
		$this->load->model('article/article');
		
		$this->data['categories'] = array();
					
		$categories = $this->model_article_category->getCategories(0);
		
		foreach ($categories as $category) {
			$children_data = array();
			
			$children = $this->model_article_category->getCategories($category['article_category_id']);
			
			foreach ($children as $child) {
				$data = array(
					'filter_article_category_id'  => $child['article_category_id'],
					'filter_sub_category' => true
				);		
					
			//	$product_total = $this->model_article_product->getTotalProducts($data);
							
				$children_data[] = array(
					'article_category_id' => $child['article_category_id'],
					'name'        => $child['name'] ,
					'href'        => $this->url->link('article/category', 'path=' . $category['article_category_id'] . '_' . $child['article_category_id'])	
				);					
			}
			
			$data = array(
				'filter_article_category_id'  => $category['article_category_id'],
				'filter_sub_category' => true	
			);		
				
			//$product_total = $this->model_article_product->getTotalProducts($data);
						
			$this->data['categories'][] = array(
				'article_category_id' => $category['article_category_id'],
				'name'        => $category['name'] ,
				'children'    => $children_data,
				'href'        => $this->url->link('article/category', 'path=' . $category['article_category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/article_category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/article_category.tpl';
		} else {
			$this->template = 'default/template/module/article_category.tpl';
		}
		
		$this->render();
  	}
}
?>