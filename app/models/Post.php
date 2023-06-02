<?php
	
	namespace App\Models;
	
	class Post extends BaseModel
	{
		private string $posts = 'posts';
		private string $likes = 'likes';
		
		public function getPost($keyword = null, $limit = null, $offset = null, $column = null, $order = null)
		{
			$sql = "SELECT * FROM $this->posts WHERE 1";
			
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
		
		public function getPostBy($column, $value)
		{
			$sql = "SELECT * FROM $this->posts WHERE $column = '$value'";
			$this->setQuery($sql);
			return $this->loadAllRows();
		}
		
		public function likePost($post_id, $user_id)
		{
			$likeSQL = "INSERT INTO $this->likes (post_id, user_id) VALUES (?, ?)";
			$this->setQuery($likeSQL);
			$this->execute([$post_id, $user_id]);
			
			$updateLikeSQL = "UPDATE $this->posts SET likes = likes + 1 WHERE id = ?";
			$this->setQuery($updateLikeSQL);
			$this->execute([$post_id]);
			
			return true;
		}
		
		public function unLikePost($post_id, $user_id)
		{
			$unlikeSQL = "DELETE FROM $this->likes WHERE post_id = ? AND user_id = ?";
			$this->setQuery($unlikeSQL);
			$this->execute([$post_id, $user_id]);
			
			$updateUnlikeSQL = "UPDATE $this->posts SET likes = likes - 1 WHERE id = ?";
			$this->setQuery($updateUnlikeSQL);
			$this->execute([$post_id]);
			
			return true;
		}
		
		
	}