<?php
	
	namespace App\Models;
	
	class Post extends BaseModel
	{
		private string $table = 'posts';
		
		public function getPost($keyword = null, $limit = null, $offset = null, $column = null, $order = null)
		{
			$sql = "SELECT * FROM $this->table WHERE 1";
			
			if ($limit !== null) {
				$sql .= " LIMIT $limit";
				if ($offset !== null) {
					$sql .= " OFFSET $offset";
				}
			}
			if ($keyword !== null) {
				$sql .= " AND (content LIKE '%$keyword%')";
			}
			if ($column !== null && $order !== null) {
				$sql .= " ORDER BY $column $order";
			}
			$this->setQuery($sql);
			return $this->loadAllRows();
		}
	}