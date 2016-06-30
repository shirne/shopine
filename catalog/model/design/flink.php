<?php
class ModelDesignFlink extends Model {	
	public function getFlink($flink_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "flink_site bi LEFT JOIN " . DB_PREFIX . "flink_site_description bid ON (bi.flink_site_id  = bid.flink_site_id) WHERE bi.flink_id = '" . (int)$flink_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->rows;
	}
}
?>