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
		$posts = $this->post->getPost($keyword, $this->Pagination()['limit'], $this->Pagination()['offset'], $column, $order);
		foreach ($posts as $post) {
			$post->media_url = explode(',', $post->media_url);
			$post->media_type = explode(',', $post->media_type);
			$post->is_liked = $this->post->isLiked($post->post_id, $user->id);
		}

		$pagination = $this->Pagination();
		$this->render("admin.post.list-post", compact('title', 'user', 'posts', 'keyword', 'pagination'));
	}

	public function Pagination(): array
	{
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$totalData = count($this->post->getPost());
		$offset = ($page - 1) * $limit; //Vị trí bắt đầu lấy dữ liệu
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
		$userID = $_SESSION['auth']->id;
		$data = $this->request->all();
		$data['user_id'] = $userID;
		$this->post->insertPost($data);
		$postID = $this->post->getLatestPostByUserId($userID);
		$medias = $this->request->file('media');
		if ($medias['name'][0] !== '') {
			foreach ($medias['name'] as $key => $media) {
				$mediaName = $this->request->uploadFile($medias['name'][$key], $medias['tmp_name'][$key], "public/uploads/posts/");
				$dataMedia = [
					'post_id' => $postID->id,
					'media_url' => $mediaName,
					'media_type' => $medias['type'][$key],
				];
				$this->post->insertPostMedia($dataMedia);
			}
		}
		return redirect('success', 'Tạo bài đăng thành công', 'back');
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
}
