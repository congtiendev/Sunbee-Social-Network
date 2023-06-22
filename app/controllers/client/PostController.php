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
        'cluster' => PUSHER_APP_CLUSTER,
        'host' => PUSHER_HOST,
        'port' => PUSHER_PORT,
        'useTLS' => PUSHER_USE_TLS,
        'encrypted' => PUSHER_ENCRYPTED,
        'scheme' => PUSHER_SCHEME,
        'debug' => PUSHER_DEBUG,
        'timeout' => PUSHER_TIMEOUT,
        'curl_options' => PUSHER_CURL_OPTIONS,
    ];
    private $pusher;

    public function __construct()
    {
        $this->post = new Post();
        $this->request = new RequestController();
        $this->validator = new Validator($this->request->all());
        $this->pusher = new Pusher\Pusher(
            PUSHER_APP_KEY,
            PUSHER_APP_SECRET,
            PUSHER_APP_ID,
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

    public function handleCreatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return redirect('', '', 'back');
        }
        $data = $this->request->all();
        $this->post->insertPost($data);
        $post_id = $this->post->getLatestPostByUserId($data['user_id']);
        $medias = $this->request->file('post_media');
        if (!empty($medias['name']) && is_array($medias['name'])) {
            foreach ($medias['name'] as $key => $media) {
                $mediaName = $this->request->uploadFile($medias['name'][$key], $medias['tmp_name'][$key], "public/uploads/posts/");
                $dataMedia = [
                    'post_id' => $post_id->id,
                    'post_media' => $mediaName
                ];
                $mediaName = [];
                $this->post->insertPostMedia($dataMedia);
            }
        }
    }
}
