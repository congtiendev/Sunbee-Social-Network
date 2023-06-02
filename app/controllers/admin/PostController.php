<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\RequestController;
use App\Models\Post;

class PostController extends BaseController
{
	private $post;
	private $request;

	public function __construct()
	{
		$this->post = new Post();
		$this->request = new RequestController();
	}

	public function renderListPost($keyword = null, $column = null, $order = null)
	{
		$title = "Danh sách bài đăng";
		$posts = $this->post->getPost($keyword, $this->Pagination()['limit'], $this->Pagination()['offset'], $column, $order);
		$pagination = $this->Pagination();
		$this->render("admin.post.list-post", compact('title', 'posts', 'keyword', 'pagination'));
	}

	public function Pagination()
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

	public function handleLikePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		if (isset($post_id) && isset($user_id)) {
			return $this->post->likePost($post_id, $user_id);
		} else {
			return redirect('errors', '', 'back');
		}
	}

	public function handleUnLikePost()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('', '', 'back');
		}
		$post_id = $this->request->post('postID');
		$user_id = $this->request->post('userID');
		if (isset($post_id) && isset($user_id)) {
			return $this->post->unLikePost($post_id, $user_id);
		} else {
			return redirect('errors', '', 'back');
		}
	}
}