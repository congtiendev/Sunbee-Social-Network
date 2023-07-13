<?php

namespace App\Models;

class Post extends BaseModel
{
	private $users = 'users';
	private $posts = 'posts';
	private $media = 'media';
	private $likes = 'likes';
	private $likes_comment = 'likes_comment';
	private $comments = 'comments';
	private $save_posts = 'save_posts';
	private $hashtags = 'hashtags';

	public function insertPost($data)
	{
		$sql = "INSERT INTO $this->posts (user_id, post_content) VALUES ( ?, ?)";
		$this->setQuery($sql);
		return $this->execute([
			$data['user_id'],
			$data['post_content'],
		]);
	}

	public function insertPostMedia($data)
	{
		$sql = "INSERT INTO $this->media (post_id ,post_media) VALUES ( ?, ?)";
		$this->setQuery($sql);
		return $this->execute([
			$data['post_id'],
			$data['post_media'],
		]);
	}

	public function getPost($keyword = null, $limit = null, $offset = null, $column = null, $order = null)
	{
		$sql = "SELECT post.*, user.*, post.id AS post_id, post.created_at AS post_date, user.id AS user_id
        FROM {$this->posts} post
        LEFT JOIN {$this->users} user ON post.user_id = user.id 
        WHERE 1
        ORDER BY post.created_at DESC";


		if ($keyword !== null) {
			$sql .= " AND (post.post_content LIKE '%$keyword%')";
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

	public function searchPost($keyword)
	{
		$sql = "SELECT post.*, user.*, post.id AS post_id, post.created_at AS post_date, user.id AS user_id
		FROM {$this->posts} post
		LEFT JOIN {$this->users} user ON post.user_id = user.id
		WHERE post.post_content LIKE '%$keyword%' OR user.username LIKE '%$keyword%' 
		GROUP BY post.id";
		$this->setQuery($sql);
		return $this->loadAllRows();
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
	public function deleteMedia($id)
	{
		$sql = "DELETE FROM $this->media WHERE post_id = ?";
		$this->setQuery($sql);
		return $this->execute([$id]);
	}

	public function deletePost($id)
	{
		$this->deleteLike($id);
		$this->deleteMedia($id);
		$comment = "DELETE FROM $this->comments WHERE post_id = ?";
		$this->setQuery($comment);
		$this->execute([$id]);
		$savePost = "DELETE FROM $this->save_posts WHERE post_id = ?";
		$this->setQuery($savePost);
		$this->execute([$id]);
		$post = "DELETE FROM $this->posts WHERE id = ?";
		$this->setQuery($post);
		$this->execute([$id]);
		return true;
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

		$updateLikeSQL = "UPDATE $this->posts SET like_count = like_count + 1 WHERE id = ?";
		$this->setQuery($updateLikeSQL);
		$this->execute([$post_id]);

		return true;
	}

	public function unLikePost($post_id, $user_id)
	{
		$unlikeSQL = "DELETE FROM $this->likes WHERE post_id = ? AND user_id = ?";
		$this->setQuery($unlikeSQL);
		$this->execute([$post_id, $user_id]);

		$updateLikeSQL = "UPDATE $this->posts SET like_count = like_count - 1 WHERE id = ? AND like_count > 0";
		$this->setQuery($updateLikeSQL);
		$this->execute([$post_id]);

		return true;
	}

	public function deleteLike($id)
	{
		$sql = "DELETE FROM $this->likes WHERE post_id = ?";
		$this->setQuery($sql);
		return $this->execute([$id]);
	}

	public function savePost($post_id, $user_id)
	{
		$sql = "INSERT INTO $this->save_posts (post_id, user_id) VALUES (?, ?)";
		$this->setQuery($sql);
		return $this->execute([$post_id, $user_id]);
	}

	public function isSaved($post_id, $user_id)
	{
		$sql = "SELECT * FROM $this->save_posts WHERE post_id = ? AND user_id = ?";
		$this->setQuery($sql);
		return $this->loadRow([$post_id, $user_id]);
	}

	public function unSavePost($post_id, $user_id)
	{
		$sql = "DELETE FROM $this->save_posts WHERE post_id = ? AND user_id = ?";
		$this->setQuery($sql);
		return $this->execute([$post_id, $user_id]);
	}

	public function insertComment($data)
	{
		$sql = "INSERT INTO $this->comments (post_id, user_id, comment_content,comment_media) VALUES (?, ?, ?,?)";
		$this->setQuery($sql);
		$this->execute([
			$data['post_id'],
			$data['user_id'],
			$data['comment_content'],
			$data['comment_media'],
		]);
		$commentCountSQL = "UPDATE $this->posts SET comment_count = comment_count + 1 WHERE id = ?";
		$this->setQuery($commentCountSQL);
		$this->execute([$data['post_id']]);
		return true;
	}
	public function updateCommentCount($post_id)
	{
		$sql = "UPDATE $this->posts SET comment_count = comment_count + 1 WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute([$post_id]);
	}



	public function isLikedComment($comment_id, $user_id)
	{
		$sql = "SELECT * FROM $this->likes_comment WHERE comment_id = ? AND user_id = ?";
		$this->setQuery($sql);
		return $this->loadRow([$comment_id, $user_id]);
	}
	public function likeComment($comment_id, $user_id)
	{
		$likeSQL = "INSERT INTO $this->likes_comment (comment_id, user_id) VALUES (?, ?)";
		$this->setQuery($likeSQL);
		$this->execute([$comment_id, $user_id]);

		$updateLikeSQL = "UPDATE $this->comments SET like_count = like_count + 1 WHERE id = ?";
		$this->setQuery($updateLikeSQL);
		$this->execute([$comment_id]);

		return true;
	}

	public function unLikeComment($comment_id, $user_id)
	{
		$unlikeSQL = "DELETE FROM $this->likes_comment WHERE comment_id = ? AND user_id = ?";
		$this->setQuery($unlikeSQL);
		$this->execute([$comment_id, $user_id]);

		$updateLikeSQL = "UPDATE $this->comments SET like_count = like_count - 1 WHERE id = ? AND like_count > 0";
		$this->setQuery($updateLikeSQL);
		$this->execute([$comment_id]);

		return true;
	}

	public function deleteLikeComment($id)
	{
		$sql = "DELETE FROM $this->likes_comment WHERE comment_id = ?";
		$this->setQuery($sql);
		return $this->execute([$id]);
	}
	public function deleteComment($post_id, $comment_id)
	{
		$commentSQL = "DELETE FROM $this->comments WHERE id = ?";
		$this->setQuery($commentSQL);
		$this->execute([$comment_id]);
		$commentCountSQL = "UPDATE $this->posts SET comment_count = comment_count - 1 WHERE id = ?";
		$this->setQuery($commentCountSQL);
		$this->execute([$post_id]);
		return true;
	}


	public function getPostBy($column, $value)
	{
		$sql = "SELECT * FROM $this->posts WHERE $column = ?";
		$this->setQuery($sql);
		return $this->loadAllRows([$value]);
	}

	public function getLikeCount($post_id)
	{
		$sql = "SELECT like_count FROM $this->posts WHERE id = ?";
		$this->setQuery($sql);
		return $this->loadRow([$post_id]);
	}
	public function getLikeCommentCount($comment_id)
	{
		$sql = "SELECT like_count FROM $this->comments WHERE id = ?";
		$this->setQuery($sql);
		return $this->loadRow([$comment_id]);
	}
	public function getLatestPostByUserId($user_id)
	{
		$sql = "SELECT * FROM $this->posts WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
		$this->setQuery($sql);
		return $this->loadRow([$user_id]);
	}



	public function getPostMedia($post_id)
	{
		$sql = "SELECT post_media FROM $this->media WHERE post_id = ?";
		$this->setQuery($sql);
		return $this->loadAllRows([$post_id]);
	}

	public function getPostComment($post_id)
	{
		$sql = "SELECT comment.*, user.*, comment.id AS comment_id, comment.created_at AS comment_date, user.id AS user_id
		FROM {$this->comments} comment
		LEFT JOIN {$this->users} user ON comment.user_id = user.id WHERE post_id = ?";
		$this->setQuery($sql);
		return $this->loadAllRows([$post_id]);
	}
	public function getCommentBy($column, $value)
	{
		$sql = "SELECT * FROM $this->comments WHERE $column = '$value'";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function getCommentMedia($comment_id)
	{
		$sql = "SELECT comment_media FROM $this->comments WHERE id = ?";
		$this->setQuery($sql);
		return $this->loadAllRows([$comment_id]);
	}
	public function getLatestCommentByUserId($user_id, $post)
	{
		$sql = "SELECT * FROM $this->comments WHERE user_id = ? AND post_id = ? ORDER BY created_at DESC LIMIT 1";
		$this->setQuery($sql);
		return $this->loadRow([$user_id, $post]);
	}
}
