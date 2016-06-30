<?php
class ModelArticleCategory extends Model {
	public function addCategory($data) {
		$name='';
		$this->db->query("INSERT INTO " . DB_PREFIX . "article_category SET parent_id = '" . (int)$data['parent_id'] . "', code = '" . $this->db->escape($data['code']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
	
		$category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article_category SET image = '" . $this->db->escape($data['image']) . "' WHERE article_category_id = '" . (int)$category_id . "'");
		}
		
		foreach ($data['article_category_description'] as $language_id => $value) {
			if($this->config->get('config_language_id')==$language_id)
				$name=$this->makeSlugs($this->db->escape($value['name']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_description SET article_category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_to_store SET article_category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_to_layout SET article_category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_category_id=" . (int)$category_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_category_id=" . (int)$category_id . "', keyword = '" .$name  . "'");
		}
		
		$this->cache->delete('article_category');
	}
	
	public function editCategoryStatus($category_id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX . "article_category SET status = '" . (int)$status. "' WHERE article_category_id = '" . (int)$category_id . "'");
	}
	
	public function editCategory($category_id, $data) {
		$name='';
		$this->db->query("UPDATE " . DB_PREFIX . "article_category SET parent_id = '" . (int)$data['parent_id'] . "', code = '" . $this->db->escape($data['code']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE article_category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article_category SET image = '" . $this->db->escape($data['image']) . "' WHERE article_category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_description WHERE article_category_id = '" . (int)$category_id . "'");

		foreach ($data['article_category_description'] as $language_id => $value) {
			if($this->config->get('config_language_id')==$language_id)
				$name=$this->makeSlugs($this->db->escape($value['name']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_description SET article_category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_to_store WHERE article_category_id = '" . (int)$category_id . "'");
		
		if (isset($data['category_store'])) {		
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_to_store SET article_category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_to_layout WHERE article_category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_category_to_layout SET article_category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'article_category_id=" . (int)$category_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_category_id=" . (int)$category_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_category_id=" . (int)$category_id . "', keyword = '" .$name  . "'");
		}
		
		$this->cache->delete('article_category');
	}
	
	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category WHERE article_category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_description WHERE article_category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_to_store WHERE article_category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_category_to_layout WHERE article_category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'article_category_id=" . (int)$category_id . "'");
		
		$query = $this->db->query("SELECT article_category_id FROM " . DB_PREFIX . "article_category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['article_category_id']);
		}
		
		$this->cache->delete('article_category');
	} 

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'article_category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "article_category WHERE article_category_id = '" . (int)$category_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories($parent_id) {
		$category_data = $this->cache->get('article_category.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_category c LEFT JOIN " . DB_PREFIX . "article_category_description cd ON (c.article_category_id = cd.article_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'article_category_id' => $result['article_category_id'],
					'code' => $result['code'],
					'name'        => $this->getPath($result['article_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['article_category_id']));
			}	
	
			$this->cache->set('article_category.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		}
		
		return $category_data;
	}
	
	public function getPath($category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "article_category c LEFT JOIN " . DB_PREFIX . "article_category_description cd ON (c.article_category_id = cd.article_category_id) WHERE c.article_category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		$category_info = $query->row;
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_category_description WHERE article_category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}	
	
	public function getCategoryStores($category_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_category_to_store WHERE article_category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_category_to_layout WHERE article_category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $category_layout_data;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_category");
		
		return $query->row['total'];
	}	
		
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>