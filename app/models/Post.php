<?php

namespace App\Models;

class Post extends BaseModel
{
	private $users = 'users';
	private $posts = 'posts';
	private $likes = 'likes';
	private $media = 'media';


	public function getPost($keyword = null, $limit = null, $offset = null, $column = null, $order = null)
	{
		/*
	GROUP_CONCAT(media.media_url) AS media_urls để nhóm các URL của media thành một chuỗi media_url dựa trên post_id.
	Sau đó bên controller sẽ dùng explode để tách chuỗi thành mảng và hiển thị ra view.
	Nếu không dùng GROUP_CONCAT thì sẽ bị hiển thị nhiều bài post trùng nhau.
	*/
		$sql = "SELECT post.*, user.*,post.id AS post_id, user.id AS user_id ,media.media_url, media.media_type
		FROM {$this->posts} post
		LEFT JOIN {$this->users} user ON post.user_id = user.id
		LEFT JOIN (
		SELECT post_id, GROUP_CONCAT(media_url) AS media_url, GROUP_CONCAT(media_type) AS media_type
		FROM {$this->media}
		GROUP BY post_id
	) media ON post.id = media.post_id";

		if ($keyword !== null) {
			$sql .= " AND (post.content LIKE '%$keyword%')";
		}

		if ($column !== null && $order !== null) {
			$sql .= " ORDER BY post.$column $order";
		}

		if ($limit !== null) {
			$sql .= " LIMIT $limit";
			if ($offset !== null) {
				$sql .= " OFFSET $offset";
			}
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
	public function isLiked($post_id, $user_id)
	{
		$sql = "SELECT * FROM $this->likes WHERE post_id = ? AND user_id = ?";
		$this->setQuery($sql);
		return $this->loadRow([$post_id, $user_id]);
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

		$updateLikeSQL = "UPDATE $this->posts SET likes = likes - 1 WHERE id = ? AND likes > 0";
		$this->setQuery($updateLikeSQL);
		$this->execute([$post_id]);

		return true;
	}

	public function insertPost($data)
	{
		$sql = "INSERT INTO $this->posts (user_id, content) VALUES ( ?, ?)";
		$this->setQuery($sql);
		return $this->execute([
			$data['user_id'],
			$data['content'],
		]);
	}

	public function insertPostMedia($data)
	{
		$sql = "INSERT INTO $this->media (post_id, media_type, media_url) VALUES (?, ?, ?)";
		$this->setQuery($sql);
		return $this->execute([
			$data['post_id'],
			$data['media_type'],
			$data['media_url'],
		]);
	}

	//lấy bài viết mới nhất theo user_id
	public function getLatestPostByUserId($user_id)
	{
		$sql = "SELECT * FROM $this->posts WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
		$this->setQuery($sql);
		return $this->loadRow([$user_id]);
	}

	public function getPostMedia($post_id)
	{
		$sql = "SELECT * FROM $this->media WHERE post_id = ?";
		$this->setQuery($sql);
		return $this->loadAllRows([$post_id]);
	}
	public function updatePost($data)
	{
		$sql = "UPDATE $this->posts SET content = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute([
			$data['content'],
			$data['id'],
		]);
	}

	public function deletePost($id)
	{
		$sql = "DELETE FROM $this->posts WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute([$id]);
	}
}
