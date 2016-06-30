<?php
class ModelLocalisationEditor extends Model {
	public function addEditor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "editor SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', locale = '" . $this->db->escape($data['locale']) . "', directory = '" . $this->db->escape($data['directory']) . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', status = '" . (int)$data['status'] . "'");
		
		$this->cache->delete('editor');
		
	}

	public function showEditor($editor_code,$args=array()){
		$editor = $this->getEditor($editor_code,'code');
		foreach ($args as $key => $value) {
			$editor['locale']=str_replace('{%'.$key.'%}', $value, $editor['locale']);
		}
		return htmlspecialchars_decode($editor['locale']);
	}
	
	public function editEditor($editor_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "editor SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', locale = '" . $this->db->escape($data['locale']) . "', directory = '" . $this->db->escape($data['directory']) . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', status = '" . (int)$data['status'] . "' WHERE editor_id = '" . (int)$editor_id . "'");
				
		$this->cache->delete('editor');
	}
	
	public function deleteEditor($editor_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "editor WHERE editor_id = '" . (int)$editor_id . "'");
		
		$this->cache->delete('editor');
		
		
	}
	
	public function getEditor($editor_id, $field='editor_id') {
		if(!in_array($field, array('editor_id','code','directory'))){
			$field='editor_id';
		}
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "editor WHERE ".$field." = '" . $this->db->escape($editor_id) . "'");
		return $query->row;
	}

	public function getEditors($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "editor";
	
			$sort_data = array(
				'name',
				'code',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY sort_order, name";	
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
		} else {
			$editor_data = $this->cache->get('editor');
		
			if (!$editor_data) {
				$editor_data = array();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "editor ORDER BY sort_order, name");
	
    			foreach ($query->rows as $result) {
      				$editor_data[$result['code']] = array(
        				'editor_id' => $result['editor_id'],
        				'name'        => $result['name'],
        				'code'        => $result['code'],
						'locale'      => $result['locale'],
						'image'       => $result['image'],
						'directory'   => $result['directory'],
						'sort_order'  => $result['sort_order'],
						'status'      => $result['status']
      				);
    			}	
			
				$this->cache->set('editor', $editor_data);
			}
		
			return $editor_data;			
		}
	}

	public function getTotalEditors() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "editor");
		
		return $query->row['total'];
	}
}
?>