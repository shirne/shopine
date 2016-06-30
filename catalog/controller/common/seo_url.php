<?php
class ControllerCommonSeoUrl extends Controller {
	private $category_map=array(
		'product/category'=>'category_id',
		'article/category'=>'article_category_id',
		'information/category'=>'information_category_id'
		);

	private $url_cache=array();

	private $seo;

	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		$this->seo= new SEO($this->registry);
		
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
			
			
			$rules=$this->getRules($parts);
			foreach ($parts as $part) {
				/*$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE lower(keyword) = '" . strtolower($this->db->escape($part)) . "'");
				
				if ($query->num_rows) {*/
				if(isset($rules[$part])){
					/*$url = explode('=', $query->row['query']);*/
					$url = explode('=', $rules[$part]);
					
					$this->seo->decode($url[0]);
					switch ($url[0]) {
						case 'product_id':
							$this->request->get['product_id'] = $url[1];
							break;
						case 'category_id':
							$this->request->get['category_id'] = $url[1];
							if (!isset($this->request->get['path'])) {
								$this->request->get['path'] = $url[1];
							} else {
								$this->request->get['path'] .= '_' . $url[1];
							}
							break;
						case 'article_category_id':
							$this->request->get['article_category_id'] = $url[1];
							if (!isset($this->request->get['path'])) {
								$this->request->get['path'] = $url[1];
							} else {
								$this->request->get['path'] .= '_' . $url[1];
							}
							break;
						case 'information_category_id':
							$this->request->get['information_category_id'] = $url[1];
							if (!isset($this->request->get['path'])) {
								$this->request->get['path'] = $url[1];
							} else {
								$this->request->get['path'] .= '_' . $url[1];
							}
							break;
						case 'manufacturer_id':
							$this->request->get['manufacturer_id'] = $url[1];
							break;
						case 'information_id':
							$this->request->get['information_id'] = $url[1];
							break;
						case 'article_id':
							$this->request->get['article_id'] = $url[1];
							break;
						default:
							# code...
							break;
					}
					/*if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}	*/
				} else {
					$this->request->get['route'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['category_id'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['article_category_id'])) {
				$this->request->get['route'] = 'article/category';
			} elseif (isset($this->request->get['information_category_id'])) {
				$this->request->get['route'] = 'information/category';
			} elseif (isset($this->request->get['article_id'])) {
				$this->request->get['route'] = 'article/article';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer/product';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			}
			
	
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}

	private function getRules($parts){
		$query=array();
		foreach ($parts as $key => $part) {
			if(!in_array($part, $query)){
				$query[]= "'".strtolower($this->db->escape(substr($part,0,100)))."'";
			}
			//max 10 levels
			if($key>10){
				break;
			}
		}
		$rules=array();
		if(!empty($query)){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE lower(keyword) in (" . implode(',',$query) . ")");
			foreach ($query->rows as $key => $value) {
				$rules[$value['keyword']]=$value['query'];
			}
		}
		return $rules;
	}

	public function rewrite($link) {
		if(isset($this->url_cache[$link]))return $this->url_cache[$link];
		//$seo= new SEO($this->registry);
		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));
		
			$url = ''; 
			
			$data = array();
			if(isset($url_data['query']))
				parse_str($url_data['query'], $data);
			
			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					$url .= $this->seo->rewrite($data['route']);
					
					if (($data['route'] == 'product/product' && $key == 'product_id') ||
						($data['route'] == 'article/article' && $key == 'article_id') ||
						(($data['route'] == 'product/manufacturer/product' || $data['route'] == 'product/product') && $key == 'manufacturer_id') ||
						($data['route'] == 'information/information' && $key == 'information_id')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
							
							unset($data[$key]);
						}					
					} elseif ($key == 'path' && isset($this->category_map[$data['route']])) {
						$categories = explode('_', $value);
						$qkey=$this->category_map[$data['route']];

						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '".$qkey."=" . (int)$category . "'");
					
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}							
						}
						
						unset($data[$key]);
					}
				}
			}
		
			if ($url) {
				unset($data['route']);
			
				$query = '';
			
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}
			
				$furl = strtolower($url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query);
			} else {
				// rewrite URL base rule
				if ($this->config->get('config_seo_url')) {
					$furl = $link;
				}else{
					$furl = $this->seo->rewrite_base_rule($link);
				}
				// end 
			}
		} else {
				// rewrite URL base rule
				if ($this->config->get('config_seo_url')) {
					$furl = $this->seo->rewrite_base_rule($link);
				}else{
					$furl = $link;
				}
				// end 
		}
		$this->url_cache[$link]=$furl;

		return $furl;
	}
	
	/*public function rewrite($link) {
		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));
		
			$url = ''; 
			
			$data = array();
			
			//parse_str($url_data['query'], $data);
			$seo= new SEO($this->registry);
			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					$url .= $seo->rewrite($data['route']);
					
					if (($data['route'] == 'product/product' && $key == 'product_id') ||
						($data['route'] == 'article/article' && $key == 'article_id') ||
						(($data['route'] == 'product/manufacturer/product' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || 
						($data['route'] == 'information/information' && $key == 'information_id')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
							
							unset($data[$key]);
						}					
					} elseif ($key == 'path' && in_array($data['route'], $this->category_map)) {
						$categories = explode('_', $value);
						$qkey=$this->category_map[$data['route']];
						
						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '".$qkey."=" . (int)$category . "'");
					
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}							
						}
						
						unset($data[$key]);
					}
				}
			}
		
			if ($url) {
				unset($data['route']);
			
				$query = '';
			
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}

				return strtolower($url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query);
			} else {
				return strtolower($link);
			}
		} else {
			return strtolower($link);
		}		
	}	*/
}
?>