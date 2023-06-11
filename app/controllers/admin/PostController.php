<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\RequestController;
use App\Validation\Validator;
use App\Models\Post;

class PostController extends BaseController
{
	private $post;
	private $request;
	private $validator;

	public function __construct()
	{
		$this->post = new Post();
		$this->request = new RequestController();
		$this->validator = new Validator($this->request->all());
	}

	public function renderListPost($keyword = null, $column = null, $order = null)
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
			return $this->post->unLikePost($post_id, $user_id);
		}
		return $this->post->likePost($post_id, $user_id);
	}

	public function handleUnLikePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		return $this->post->unLikePost($post_id, $user_id);
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

	public function handleAddComment()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$data = $this->request->all();
		$comment_media = $this->request->file('comment_media');
		if ($comment_media !== null && $comment_media['name'] !== '') {
			$data['comment_media'] = $this->request->uploadFile($comment_media['name'], $comment_media['tmp_name'], "public/uploads/comments/");
		} else {
			$data['comment_media'] = "";
		}
		return $this->post->insertComment($data);
	}
}
