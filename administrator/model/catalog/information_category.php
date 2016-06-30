<?php
class ModelCatalogInformationCategory extends Model {
	public function addCategory($data) {
		$name='';
		$this->db->query("INSERT INTO " . DB_PREFIX . "information_category SET parent_id = '" . (int)$data['parent_id'] . "',sort_order = '" . (int)$data['sort_order'] . "'");
	
		$information_category_id = $this->db->getLastId();
		
		foreach ($data['category_description'] as $language_id => $value) {
			if($this->config->get('config_language_id')==$language_id)
				$name=$this->makeSlugs($this->db->escape($value['name']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_description SET information_category_id = '" . (int)$information_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->cache->delete('information_category');
	}
	
	public function editCategory($information_category_id, $data) {
		$name='';
		$this->db->query("UPDATE " . DB_PREFIX . "information_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE information_category_id = '" . (int)$information_category_id . "'");


		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . (int)$information_category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			if($this->config->get('config_language_id')==$language_id)
				$name=$this->makeSlugs($this->db->escape($value['name']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_description SET information_category_id = '" . (int)$information_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . (int)$information_category_id. "'");
		
		/*if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_category_id=" . (int)$information_category_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_category_id=" . (int)$information_category_id . "', keyword = '" .$name  . "'");
		}*/
		
		$this->cache->delete('information_category');
	}
	
	public function deleteCategory($information_category_id) {
		$information_category_id = (int)$information_category_id;
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category WHERE information_category_id = '" . $information_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . $information_category_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . $information_category_id . "'");
		
		if($information_category_id != 0){
			$query = $this->db->query("SELECT information_category_id FROM " . DB_PREFIX . "information_category WHERE parent_id = '" . (int)$information_category_id . "'");

			foreach ($query->rows as $result) {
				$this->deleteCategory($result['information_category_id']);
			}
		}
		
		$this->cache->delete('information_category');
	} 

	public function getCategory($information_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . (int)$information_category_id . "') AS keyword FROM " . DB_PREFIX . "information_category WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories($parent_id) {
		$category_data = $this->cache->get('information_category.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category c LEFT JOIN " . DB_PREFIX . "information_category_description cd ON (c.information_category_id = cd.information_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'information_category_id' => $result['information_category_id'],
					'name'        => $this->getPath($result['information_category_id'], $this->config->get('config_language_id')),
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['information_category_id']));
			}	
	
			$this->cache->set('information_category.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		}
		
		return $category_data;
	}
	
	public function getPath($information_category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "information_category c LEFT JOIN " . DB_PREFIX . "information_category_description cd ON (c.information_category_id = cd.information_category_id) WHERE c.information_category_id = '" . (int)$information_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		$category_info = $query->row;
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	public function getCategoryDescriptions($information_category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}	
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_category");
		
		return $query->row['total'];
	}	
	
}
?>