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
		}
	}