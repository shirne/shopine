<?php
class ModelCatalogInformationCategory extends Model {
	public function getCategory($information_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information_category c LEFT JOIN " . DB_PREFIX . "information_category_description cd ON (c.information_category_id = cd.information_category_id) WHERE c.information_category_id = '" . (int)$information_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category c LEFT JOIN " . DB_PREFIX . "information_category_description cd ON (c.information_category_id = cd.information_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, LCASE(cd.name)");
		
		return $query->rows;
	}

	public function getCategoriesByParentId($information_category_id) {
		$information_category_data = array();
		
		$information_category_data[] = $information_category_id;
		
		$information_category_query = $this->db->query("SELECT information_category_id FROM " . DB_PREFIX . "information_category WHERE parent_id = '" . (int)$information_category_id . "'");
		
		foreach ($information_category_query->rows as $information_category) {
			$children = $this->getCategoriesByParentId($information_category['information_category_id']);
			
			if ($children) {
				$information_category_data = array_merge($children, $information_category_data);
			}			
		}
		
		return $information_category_data;
	}
		
	public function getCategoryLayoutId($information_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_to_layout WHERE information_category_id = '" . (int)$information_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_information_category');
		}
	}
					
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_category c LEFT JOIN " . DB_PREFIX . "information_category_to_store c2s ON (c.information_category_id = c2s.information_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}
}
?>