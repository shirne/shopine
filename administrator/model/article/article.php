<?php
class ModelArticleArticle extends Model {
	public function addArticle($data) {
		
		$group_id=$this->getMaxGroupid()+1;
		foreach ($data['article'] as $language_id => $value) {
			$title=$value['title'];
			if(empty($title))continue;
			if($this->config->get('config_language_id')==$language_id)
				$title=$this->makeSlugs($this->db->escape($value['title']));
			$this->db->query("INSERT INTO " . DB_PREFIX . "article SET group_id='$group_id', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");
			$article_id = $this->db->getLastId();

			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "article SET image = '" . $this->db->escape($data['image']) . "' WHERE article_id = '" . (int)$article_id . "'");
			}

			if (isset($data['article_download'])) {
				foreach ($data['article_download'] as $download_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
				}
			}

			if (isset($data['article_category'])) {
				foreach ($data['article_category'] as $category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_category SET article_id = '" . (int)$article_id . "', article_category_id = '" . (int)$category_id . "'");
				}
			}

			if (isset($data['article_related'])) {
				foreach ($data['article_related'] as $related_id) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
					$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
				}
			}

			if (isset($data['article_store'])) {
				foreach ($data['article_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
				}
			}

			if (isset($data['article_layout'])) {
				foreach ($data['article_layout'] as $store_id => $layout) {
					if ($layout['layout_id']) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
					}
				}
			}

			foreach ($data['article_tag'] as $language_id => $value) {
				if ($value) {
					$tags = explode(',', $value);

					foreach ($tags as $tag) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "article_tag SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
					}
				}
			}

			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
			}else{
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $title . "'");
			}

		}


		$this->cache->delete('article');
	}

	public function editArticle($article_id, $data) {
		
		$title=$data['title'];
		$language_id=$data['language_id'];
		if($this->config->get('config_language_id')==$language_id)
			$title=$this->makeSlugs($this->db->escape($data['title']));

		$this->db->query("UPDATE " . DB_PREFIX . "article SET language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($data['title']) . "', meta_title = '" . $this->db->escape($data['meta_title']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', content = '" . $this->db->escape($data['content']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE article_id = '" . (int)$article_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article SET image = '" . $this->db->escape($data['image']) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_download'])) {
			foreach ($data['article_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_category SET article_id = '" . (int)$article_id . "', article_category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE related_id = '" . (int)$article_id . "'");

		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_tag WHERE article_id = '" . (int)$article_id. "'");

		if ($data['article_tag']) {
			$tags = explode(',', $data['article_tag']);

			foreach ($tags as $tag) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_tag SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'article_id=" . (int)$article_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $title . "'");
		}

		$this->cache->delete('article');
	}

	/*public function editArticles($group_id, $data) {
		
		foreach ($data['article'] as $language_id => $value) {
			$title=$value['title'];
			$row=$this->getArticle($group_id,$language_id);
			$article_id=$row['article_id'];
			if($this->config->get('config_language_id')==$language_id)
				$title=$this->makeSlugs($this->db->escape($value['title']));
			$this->db->query("UPDATE " . DB_PREFIX . "article SET language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', status = '" . (int)$value['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE article_id = '" . (int)$article_id . "'");
			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "article SET image = '" . $this->db->escape($data['image']) . "' WHERE article_id = '" . (int)$article_id . "'");
			}
			
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");

			if (isset($data['article_download'])) {
				foreach ($data['article_download'] as $download_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
				}
			}

			$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");

			if (isset($data['article_category'])) {
				foreach ($data['article_category'] as $category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_category SET article_id = '" . (int)$article_id . "', category_id = '" . (int)$category_id . "'");
				}
			}

			$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE related_id = '" . (int)$article_id . "'");

			if (isset($data['article_related'])) {
				foreach ($data['article_related'] as $related_id) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
					$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
				}
			}

			

			$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");

			if (isset($data['article_layout'])) {
				foreach ($data['article_layout'] as $store_id => $layout) {
					if ($layout['layout_id']) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
					}
				}
			}

			$this->db->query("DELETE FROM " . DB_PREFIX . "article_tag WHERE article_id = '" . (int)$article_id. "'");

			foreach ($data['article_tag'] as $language_id => $value) {
				if ($value) {
					$tags = explode(',', $value);

					foreach ($tags as $tag) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "article_tag SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
					}
				}
			}

			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'article_id=" . (int)$article_id. "'");

			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->makeSlugs($this->db->escape($data['keyword'])) . "'");
			}else{
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'article_id=" . (int)$article_id . "', keyword = '" . $title . "'");
			}

		}

		$this->cache->delete('article');
	}*/

	public function copyArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "article a WHERE a.article_id = '" . (int)$article_id . "' AND a.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data['article'][$this->config->get('config_language_id')] = $query->row;

			$data['keyword'] = '';

			$data['status'] = '0';
			
			// FIXME just for test
			//$data['status'] = '1';

			$data = array_merge($data, array('article_related' => $this->getArticleRelated($article_id)));
			$data = array_merge($data, array('article_tag' => $this->getArticleTags($article_id)));
			$data = array_merge($data, array('article_category' => $this->getArticleCategories($article_id)));
			$data = array_merge($data, array('article_download' => $this->getArticleDownloads($article_id)));
			$data = array_merge($data, array('article_layout' => $this->getArticleLayouts($article_id)));
			$data = array_merge($data, array('article_store' => $this->getArticleStores($article_id)));
			
			//$index=20000;
			//for ($i = 0; $i < $index; $i++) {
			$this->addArticle($data);
			//}
			
		}
	}

	public function deleteArticle($article_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_tag WHERE article_id='" . (int)$article_id. "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' OR related_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'article_id=" . (int)$article_id. "'");
		
		$this->cache->delete('article');
	}

	public function getArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'article_id=" . (int)$article_id . "') AS keyword FROM " . DB_PREFIX . "article a WHERE a.article_id = '" . (int)$article_id . "' AND a.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getArticleByGroupid($group_id,$language_id){
		$query=$this->db->query("SELECT * FROM " . DB_PREFIX . "article WHERE group_id = '" . (int)$group_id . "' AND language_id='".(int)$language_id."'");

		return $query->row;
	}

	public function updateArticleStatus($article_id,$status) {
		$this->db->query("UPDATE " . DB_PREFIX . "article SET status = '" . (int)$status . "' WHERE article_id = '" . (int)$article_id . "'");
	}

	public function getArticlesByGroupid($group_id) {
		$query=$this->db->query("SELECT * FROM " . DB_PREFIX . "article WHERE group_id = '" . (int)$group_id . "'");
		$articles=array();
		$articles['group_id']=empty($query->row['group_id'])?0:$query->row['group_id'];
		
		foreach ($$query->rows as $key => $value) {
			$articles[$value['language_id']]=$value;
		}

		return $articles;
	}
	
	public function getArticles($data = array()) {
		if ($data) {
			$sql = "SELECT DISTINCT a.article_id AS upid, a.* FROM " . DB_PREFIX . "article a ";

			if (isset($data['filter_category_id'])&& !is_null($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "article_to_category p2c ON (a.article_id = p2c.article_id)";
			}
			
				$sql.=" WHERE a.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
				$sql .= " AND LCASE(a.title) LIKE BINARY '%" . $this->db->escape(mb_strtolower($data['filter_title'], 'UTF-8')) . "%'";
			}

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND a.status = '" . (int)$data['filter_status'] . "'";
			}

			if (isset($data['filter_category_id'])&& !is_null($data['filter_category_id'])&&$data['filter_category_id']!='') {
				$sql .= " AND ( p2c.article_category_id = '" . (int)$data['filter_category_id'] . "'";
				$sql .= " OR  p2c.article_category_id IN ( SELECT article_category_id FROM " . DB_PREFIX . "article_category  WHERE parent_id='" . (int)$data['filter_category_id'] . "' ))";
			}
			
			$sort_data = array(
				'a.title',
				'a.status',
				'a.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY a.title";
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
			$article_data = $this->cache->get('article.' . $this->config->get('config_language_id'));

			if (!$article_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article a WHERE a.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.title ASC");

				$article_data = $query->rows;

				$this->cache->set('article.' . $this->config->get('config_language_id'), $article_data);
			}

			return $article_data;
		}
	}

	public function getArticlesByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article a LEFT JOIN " . DB_PREFIX . "article_to_category p2c ON (a.article_id = p2c.article_id) WHERE a.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.article_category_id = '" . (int)$category_id . "' ORDER BY a.title ASC");

		return $query->rows;
	}

	public function getArticleDownloads($article_id) {
		$article_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_download_data[] = $result['download_id'];
		}

		return $article_download_data;
	}

	public function getArticleStores($article_id) {
		$article_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}

		return $article_store_data;
	}

	public function getArticleLayouts($article_id) {
		$article_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $article_layout_data;
	}

	public function getArticleCategories($article_id) {
		$article_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_category_data[] = $result['article_category_id'];
		}

		return $article_category_data;
	}

	public function getArticleRelated($article_id) {
		$article_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}

		return $article_related_data;
	}

	public function getArticleTags($article_id) {
		$article_tag_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_tag WHERE article_id = '" . (int)$article_id . "'");

		$tag_data = array();

		foreach ($query->rows as $result) {
			$tag_data[$result['language_id']][] = $result['tag'];
		}

		foreach ($tag_data as $language => $tags) {
			$article_tag_data[$language] = implode(',', $tags);
		}

		return $article_tag_data;
	}

	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article a ";

		if (isset($data['filter_category_id'])&& !is_null($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "article_to_category p2c ON (a.article_id = p2c.article_id)";
		}
		
		$sql.=" WHERE a.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
			$sql .= " AND LCASE(a.title) LIKE LCASE('%" . $this->db->escape($data['filter_title']) . "%')";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND a.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_category_id'])&& !is_null($data['filter_category_id'])) {
			$sql .= " AND ( p2c.article_category_id = '" . (int)$data['filter_category_id'] . "'";
			$sql .= " OR  p2c.article_category_id IN ( SELECT article_category_id FROM " . DB_PREFIX . "article_category  WHERE parent_id='" . (int)$data['filter_category_id'] . "' ))";
		}
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getMaxGroupid(){
		$query = $this->db->query("SELECT MAX(group_id) AS max_group_id FROM " . DB_PREFIX . "article");
		if(empty($query->row)){
			return 0;
		}else{
			return $query->row['max_group_id'];
		}
	}

	public function getTotalArticlesByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
?>