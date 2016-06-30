<?php
class ModelArticleArticle extends Model {
	public function updateViewed($article_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "article SET viewed = (viewed + 1) WHERE article_id = '" . (int)$article_id . "'");
	}
	
	public function getArticle($article_id) {
				
		$article_cache= array('article_id'  => $article_id);
		$cache = md5(http_build_query($article_cache));
		
		$article_data = $this->cache->get('article.' . $cache.'.detail'.$article_id );
		
		if(!$article_data){
			$sql="SELECT * FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_to_store p2s ON (p.article_id = p2s.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND p.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			$query = $this->db->query($sql);
			if ($query->num_rows) {
				$article_data= array(
					'article_id'       => $query->row['article_id'],
					'title'            => $query->row['title'],
					'content'      	   => $query->row['content'],
					'meta_title'	   => $query->row['meta_title'],
					'meta_description' => $query->row['meta_description'],
					'meta_keyword'     => $query->row['meta_keyword'],
					'image'            => $query->row['image'],
					'sort_order'       => $query->row['sort_order'],
					'status'           => $query->row['status'],
					'viewed'       	   => $query->row['viewed'],
					'date_added'       => $query->row['date_added'],
					'date_modified'    => $query->row['date_modified']
				);
				$this->cache->set('article.' . $cache.'.detail'.$article_id , $article_data);
				return $article_data;
			} else {
				return false;
			}
		}else{
			return $article_data;
		}
	}

	public function getArticles($data = array()) {
		
		$cache = md5(http_build_query($data));
		
		$article_data = $this->cache->get('article.' . $cache);
		
		if (!$article_data) {
			$sql = "SELECT p.article_id FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_to_store p2s ON (p.article_id = p2s.article_id) WHERE p.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
			if (isset($data['filter_title']) && $data['filter_title']) {
				if (isset($data['filter_content']) && $data['filter_content']) {
					$sql .= " AND (LCASE(p.title) LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%' OR p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%') OR LCASE(p.content) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%')";
				} else {
					$sql .= " AND (LCASE(p.title) LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%' OR p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%'))";
				}
			}
			
			if (isset($data['filter_tag']) && $data['filter_tag']) {
				$sql .= " AND p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag)  LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_tag'], 'UTF-8')) . "%')";
			}
										
			if (isset($data['filter_category_id']) && $data['filter_category_id']) {
				if (isset($data['filter_sub_category']) && $data['filter_sub_category']) {
					$implode_data = array();
					
					$this->load->model('article/category');
					
					$categories = $this->model_article_category->getCategoriesByParentId($data['filter_category_id']);
					
					foreach ($categories as $category_id) {
						$implode_data[] = "p2c.article_category_id = '" . (int)$category_id . "'";
					}
					
					$sql .= " AND p.article_id IN (SELECT p2c.article_id FROM " . DB_PREFIX . "article_to_category p2c WHERE " . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND p.article_id IN (SELECT p2c.article_id FROM " . DB_PREFIX . "article_to_category p2c WHERE p2c.article_category_id = '" . (int)$data['filter_category_id'] . "')";
				}
			}
			
			$sql .= " GROUP BY p.article_id";
			
			$sort_data = array(
				'p.title',
				'p.sort_order',
				'p.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'p.title' ) {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if (!isset($data['start']) || $data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if (!isset($data['limit']) || $data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$article_data = array();
			
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$article_data[$result['article_id']] = $this->getArticle($result['article_id']);
			}
			
			$this->cache->set('article.' . $cache , $article_data);
		}
		
		return $article_data;
	}
	
		
	public function getLatestArticles($limit) {
		$article_data = $this->cache->get('article.latest.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit);

		if (!$article_data) { 
			$query = $this->db->query("SELECT p.article_id FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_to_store p2s ON (p.article_id = p2s.article_id) WHERE p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
		 	 
			foreach ($query->rows as $result) {
				$article_data[$result['article_id']] = $this->getArticle($result['article_id']);
			}
			
			$this->cache->set('article.latest.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $limit, $article_data);
		}
		
		return $article_data;
	}
	
	public function getArticleRelated($article_id) {
		$article_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related pr LEFT JOIN " . DB_PREFIX . "article p ON (pr.related_id = p.article_id) LEFT JOIN " . DB_PREFIX . "article_to_store p2s ON (p.article_id = p2s.article_id) WHERE pr.article_id = '" . (int)$article_id . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$article_data[$result['related_id']] = $this->getArticle($result['related_id']);
		}
		
		return $article_data;
	}
		
	public function getArticleTags($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_tag WHERE article_id = '" . (int)$article_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->rows;
	}
		
	public function getArticleLayoutId($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_article');
		}
	}
	
	public function getCategories($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");
		
		return $query->rows;
	}	
		
	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_to_store p2s ON (p.article_id = p2s.article_id) WHERE p.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (isset($data['filter_title'])) {
			if (isset($data['filter_content']) && $data['filter_content']) {
				$sql .= " AND (LCASE(p.title) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%' OR p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%') OR LCASE(p.content) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%')";
			} else {
				$sql .= " AND (LCASE(p.title) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%' OR p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%'))";
			}
		}
		
		if (isset($data['filter_tag']) && $data['filter_tag']) {
			$sql .= " AND p.article_id IN (SELECT pt.article_id FROM " . DB_PREFIX . "article_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_tag'], 'UTF-8')) . "%')";
		}
									
		if (isset($data['filter_category_id']) && $data['filter_category_id']) {
			if (isset($data['filter_sub_category']) && $data['filter_sub_category']) {
				$implode_data = array();
				
				$this->load->model('article/category');
				
				$categories = $this->model_article_category->getCategoriesByParentId($data['filter_category_id']);
				
				foreach ($categories as $category_id) {
					$implode_data[] = "p2c.article_category_id = '" . (int)$category_id . "'";
				}
				
				$sql .= " AND p.article_id IN (SELECT p2c.article_id FROM " . DB_PREFIX . "article_to_category p2c WHERE " . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND p.article_id IN (SELECT p2c.article_id FROM " . DB_PREFIX . "article_to_category p2c WHERE p2c.article_category_id = '" . (int)$data['filter_category_id'] . "')";
			}
		}
		
				
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	private function getFirstLetter($str){
		$fchar = ord($str{0});
		if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($str{0});
		$s1 = iconv("UTF-8","gb2312", $str);
		$s2 = iconv("gb2312","UTF-8", $s1);
		if($s2 == $str){
			$s = $s1;
		}
		else{$s = $str;
		}
		$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
		if($asc >= -20319 and $asc <= -20284) return "A";
		if($asc >= -20283 and $asc <= -19776) return "B";
		if($asc >= -19775 and $asc <= -19219) return "C";
		if($asc >= -19218 and $asc <= -18711) return "D";
		if($asc >= -18710 and $asc <= -18527) return "E";
		if($asc >= -18526 and $asc <= -18240) return "F";
		if($asc >= -18239 and $asc <= -17923) return "G";
		if($asc >= -17922 and $asc <= -17418) return "I";
		if($asc >= -17417 and $asc <= -16475) return "J";
		if($asc >= -16474 and $asc <= -16213) return "K";
		if($asc >= -16212 and $asc <= -15641) return "L";
		if($asc >= -15640 and $asc <= -15166) return "M";
		if($asc >= -15165 and $asc <= -14923) return "N";
		if($asc >= -14922 and $asc <= -14915) return "O";
		if($asc >= -14914 and $asc <= -14631) return "P";
		if($asc >= -14630 and $asc <= -14150) return "Q";
		if($asc >= -14149 and $asc <= -14091) return "R";
		if($asc >= -14090 and $asc <= -13319) return "S";
		if($asc >= -13318 and $asc <= -12839) return "T";
		if($asc >= -12838 and $asc <= -12557) return "W";
		if($asc >= -12556 and $asc <= -11848) return "X";
		if($asc >= -11847 and $asc <= -11056) return "Y";
		if($asc >= -11055 and $asc <= -10247) return "Z";
		return null;
	}
	 
	private function pinyin($zh){
		$ret = "";
		$s1 = iconv("UTF-8","gb2312", $zh);
		$s2 = iconv("gb2312","UTF-8", $s1);
		if($s2 == $zh){
			$zh = $s1;
		}
		for($i = 0; $i < strlen($zh); $i++){
			$s1 = substr($zh,$i,1);
			$p = ord($s1);
			if($p > 160){
				$s2 = substr($zh,$i++,2);
				$ret .= $this->getFirstLetter($s2);
			}else{
				$ret .= $s1;
			}
		}
		return $ret;
	}
}
?>