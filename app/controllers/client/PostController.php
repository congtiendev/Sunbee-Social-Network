<?php

namespace App\Controllers\Client;

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
        $this->render("client.feed", compact('title', 'user', 'posts', 'keyword', 'pagination'));
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
}
