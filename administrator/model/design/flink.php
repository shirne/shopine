<?php
class ModelDesignFlink extends Model {
	public function addFlink($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "flink SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");
	
		$flink_id = $this->db->getLastId();
	
		if (isset($data['flink_site'])) {
			foreach ($data['flink_site'] as $flink_site) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "flink_site SET flink_id = '" . (int)$flink_id . "', link = '" .  $this->db->escape($flink_site['link']) . "', image = '" .  $this->db->escape($flink_site['image']) . "'");
				
				$flink_site_id = $this->db->getLastId();
				
				foreach ($flink_site['flink_site_description'] as $language_id => $flink_site_description) {				
					$this->db->query("INSERT INTO " . DB_PREFIX . "flink_site_description SET flink_site_id = '" . (int)$flink_site_id . "', language_id = '" . (int)$language_id . "', flink_id = '" . (int)$flink_id . "', title = '" .  $this->db->escape($flink_site_description['title']) . "'");
				}
			}
		}		
	}
	
	public function editFlink($flink_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "flink SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE flink_id = '" . (int)$flink_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "flink_site WHERE flink_id = '" . (int)$flink_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "flink_site_description WHERE flink_id = '" . (int)$flink_id . "'");
			
		if (isset($data['flink_site'])) {
			foreach ($data['flink_site'] as $flink_site) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "flink_site SET flink_id = '" . (int)$flink_id . "', link = '" .  $this->db->escape($flink_site['link']) . "', image = '" .  $this->db->escape($flink_site['image']) . "'");
				
				$flink_site_id = $this->db->getLastId();
				
				foreach ($flink_site['flink_site_description'] as $language_id => $flink_site_description) {				
					$this->db->query("INSERT INTO " . DB_PREFIX . "flink_site_description SET flink_site_id = '" . (int)$flink_site_id . "', language_id = '" . (int)$language_id . "', flink_id = '" . (int)$flink_id . "', title = '" .  $this->db->escape($flink_site_description['title']) . "'");
				}
			}
		}			
	}
	
	public function deleteFlink($flink_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "flink WHERE flink_id = '" . (int)$flink_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "flink_site WHERE flink_id = '" . (int)$flink_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "flink_site_description WHERE flink_id = '" . (int)$flink_id . "'");
	}
	
	public function getFlink($flink_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "flink WHERE flink_id = '" . (int)$flink_id . "'");
		
		return $query->row;
	}
		
	public function getFlinks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "flink";
		
		$sort_data = array(
			'name',
			'status'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}					

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
		
	public function getFlinkImages($flink_id) {
		$flink_site_data = array();
		
		$flink_site_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flink_site WHERE flink_id = '" . (int)$flink_id . "'");
		
		foreach ($flink_site_query->rows as $flink_site) {
			$flink_site_description_data = array();
			 
			$flink_site_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flink_site_description WHERE flink_site_id = '" . (int)$flink_site['flink_site_id'] . "' AND flink_id = '" . (int)$flink_id . "'");
			
			foreach ($flink_site_description_query->rows as $flink_site_description) {			
				$flink_site_description_data[$flink_site_description['language_id']] = array('title' => $flink_site_description['title']);
			}
		
			$flink_site_data[] = array(
				'flink_site_description' => $flink_site_description_data,
				'link'                     => $flink_site['link'],
				'image'                    => $flink_site['image']	
			);
		}
		
		return $flink_site_data;
	}
		
	public function getTotalFlinks() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "flink");
		
		return $query->row['total'];
	}	
}
?>