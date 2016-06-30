<?php  
class ControllerModuleInformationCategory extends Controller {
	protected function index() {
		$this->language->load('module/information_category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['information_category_id'] = $parts[0];
		} else {
			$this->data['information_category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}

		$this->data['information_id'] = isset($this->request->get['information_id'])?$this->request->get['information_id']:0;
							
		$this->load->model('catalog/information_category');
		$this->load->model('catalog/information');
		
		$this->data['categories'] = array();
					
		$categories = $this->model_catalog_information_category->getCategories(0);
		
		foreach ($categories as $category) {
			$children_data = array();
			
			$children = $this->model_catalog_information_category->getCategories($category['information_category_id']);
			
			foreach ($children as $child) {
							
				$children_data[] = array(
					'information_category_id' => $child['information_category_id'],
					'name'        => $child['name'] ,
					//'href'        => $this->url->link('information/category', 'path=' . $category['information_category_id'] . '_' . $child['information_category_id'])	
				);					
			}

			$page_data=array();
			
			$pages = $this->model_catalog_information->getInformations($category['information_category_id']);
			
			foreach ($pages as $page) {
							
				$page_data[] = array(
					'information_id' => $page['information_id'],
					'title'        => $page['title'] ,
					'href'        => $this->url->link('information/information', 'information_id=' . $page['information_id'])	
				);					
			}
						
			$this->data['categories'][] = array(
				'information_category_id' => $category['information_category_id'],
				'name'        => $category['name'] ,
				'children'    => $children_data,
				'pages'		  => $page_data
				//'href'        => $this->url->link('information/category', 'path=' . $category['information_category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/information_category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/information_category.tpl';
		} else {
			$this->template = 'default/template/module/information_category.tpl';
		}
		
		$this->render();
  	}
}
?>