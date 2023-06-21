<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\RequestController;
use App\Validation\Validator;
use App\Models\Post;
use Pusher;

class PostController extends BaseController
{
	private $post;
	private $request;
	private $validator;
	private $options = [
		'cluster' => 'ap1',
		'useTLS' => true
	];
	private $pusher;

	public function __construct()
	{
		$this->post = new Post();
		$this->request = new RequestController();
		$this->validator = new Validator($this->request->all());
		$this->pusher = new Pusher\Pusher(
			'c3271ec62a7f5d395eb3',
			'ff3d133f0970c64aff62',
			'1618489',
			$this->options
		);
	}

	public function renderListPost($keyword = null, $column = null, $order = null): void
	{
		$title = "Danh sách bài đăng";
		$user = $_SESSION['auth'];
		$limit = $this->Pagination()['limit'];
		$offset = $this->Pagination()['offset'];
		$posts = $this->post->getPost($keyword, $limit, $offset, $column, $order);
		foreach ($posts as $post) {
			$postID = $post->post_id;
			$post->medias = $this->post->getPostMedia($postID);
			$post->comments = $this->post->getPostComment($postID);
			$post->is_liked = $this->post->isLiked($postID, $user->id);
			$post->is_saved = $this->post->isSaved($postID, $user->id);
		}
		$pagination = $this->Pagination();
		$this->render("admin.post.list-post", compact('title', 'user', 'posts', 'keyword', 'pagination'));
	}

	public function Pagination(): array
	{
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 100;
		$totalData = count($this->post->getPost());
		$offset = ($page - 1) * $limit;
		$totalPages = round((int) ($totalData / $limit));
		return [
			'offset' => $offset,
			'total' => $totalData,
			'limit' => $limit,
			'current_page' => $page,
			'total_pages' => $totalPages,
		];
	}

	public function handleCreatePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$data = $this->request->all();
		$this->post->insertPost($data);
		$post_id = $this->post->getLatestPostByUserId($data['user_id']);
		$medias = $this->request->file('post_media');
		if ($medias['name'][0] !== '') {
			$mediaNames = []; // Mảng lưu trữ tên tất cả các tệp đính kèm
			if ($medias['name'][0] !== '') {
				foreach ($medias['name'] as $key => $media) {
					$mediaName = $this->request->uploadFile($medias['name'][$key], $medias['tmp_name'][$key], "public/uploads/posts/");
					$dataMedia = [
						'post_id' => $post_id->id,
						'post_media' => $mediaName
					];
					$mediaNames[] = $mediaName;
					$this->post->insertPostMedia($dataMedia);
				}
			}
		}
	}

	public function handleLikePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');

		if ($this->post->isLiked($post_id, $user_id)) {
			$this->post->unLikePost($post_id, $user_id);
			$like_count = $this->post->getLikeCount($post_id)->like_count;
			$this->pusher->trigger('like-post', 'unlike', [
				'post_id' => $post_id,
				'user_id' => $user_id,
				'like_count' => $like_count
			]);
		} else {
			$this->post->likePost($post_id, $user_id);
			$like_count = $this->post->getLikeCount($post_id)->like_count;
			$this->pusher->trigger('like-post', 'like', [
				'post_id' => $post_id,
				'user_id' => $user_id,
				'like_count' => $like_count
			]);
		}
	}

	public function handleUnLikePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		$this->post->unLikePost($post_id, $user_id);
		$like_count = $this->post->getLikeCount($post_id)->like_count;
		$this->pusher->trigger('like-post', 'unlike', [
			'post_id' => $post_id,
			'user_id' => $user_id,
			'like_count' => $like_count
		]);
	}

	public function handleSavePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		if ($this->post->isSaved($post_id, $user_id)) {
			return $this->post->unSavePost($post_id, $user_id);
		}
		return $this->post->savePost($post_id, $user_id);
	}
	public function handleUnSavePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		return $this->post->unSavePost($post_id, $user_id);
	}
	public function handleDeletePost($post_id)
	{
		$post_media = $this->post->getPostMedia($post_id);
		if ($post_media) {
			foreach ($post_media as $media) {
				unlink("public/uploads/posts/" . $media->post_media);
			}
		}
		$this->post->deletePost($post_id);
		$this->pusher->trigger('posts', 'delete-post', [
			'post_id' => $post_id
		]);
	}
	public function handleAddComment()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}

		$user = $_SESSION['auth'];
		$data = $this->request->all(); //Lấy dữ liệu từ form
		$comment_media = $this->request->file('comment_media'); //Lấy file từ form

		if ($comment_media !== null && $comment_media['name'] !== '') {
			$data['comment_media'] = $this->request->uploadFile($comment_media['name'], $comment_media['tmp_name'], "public/uploads/comments/"); //Upload file 
			$media_path = COMMENT_MEDIA_PATH . $data['comment_media'];
		} else {
			$data['comment_media'] = "";
			$media_path = "";
		}

		$this->post->insertComment($data);
		$new_comment = $this->post->getLatestCommentByUserId($data['user_id'], $data['post_id']);
		$comment_id = $new_comment->id;
		$avatar_path = AVATAR_PATH . $user->avatar;
		$comment_date = timeAgo($new_comment->created_at);

		$payload = [
			'user_id' => $data['user_id'],
			'post_id' => $data['post_id'],
			'comment_id' => $comment_id,
			'avatar' => $avatar_path,
			'username' => $user->username,
			'comment_content' => $data['comment_content'],
			'comment_media' => $media_path,
			'comment_date' => $comment_date
		];

		$this->pusher->trigger('comments', 'new-comment', $payload);

		header('Content-Type: application/json');
		echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
		exit;
	}

	public function handleDeleteComment($post_id, $comment_id)
	{
		$comment_media = $this->post->getCommentMedia($comment_id);
		foreach ($comment_media as $media) {
			unlink("public/uploads/comments/" . $media->comment_media);
		}
		$this->post->deleteComment($post_id, $comment_id);
		$this->pusher->trigger('comments', 'delete-comment', ['post_id' => $post_id, 'comment_id' => $comment_id]);
		header('Content-Type: application/json');
		echo json_encode(['success' => true, 'message' => 'Comment deleted successfully']);
		exit;
	}

	public function searchPost()
	{
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
		if ($keyword === null) {
			return redirect('', '', 'back');
		}
		$this->renderListPost($keyword);
	}
}
