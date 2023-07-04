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
        'useTLS' => PUSHER_USE_TLS,
        'encrypted' => PUSHER_ENCRYPTED,
        'scheme' => PUSHER_SCHEME,
        'timeout' => PUSHER_TIMEOUT,
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
        $user = $_SESSION['auth'];
        $avatar = $user->avatar ? $user->avatar : 'default-avatar.jpg';
        $this->post->insertPost($data);
        $new_post = $this->post->getLatestPostByUserId($data['user_id']);
        $medias = $this->request->file('post_media');
        if (!empty($medias['name']) && is_array($medias['name'])) {
            foreach ($medias['name'] as $key => $media) {
                $mediaName = $this->request->uploadFile($medias['name'][$key], $medias['tmp_name'][$key], "public/uploads/posts/");
                $mediaPaths[] = $mediaName;
                $dataMedia = [
                    'post_id' => $new_post->id,
                    'post_media' => $mediaName
                ];
                $this->post->insertPostMedia($dataMedia);
            }
        }
        $payload = [
            'user_id' => $user->id,
            'avatar' => AVATAR_PATH . $avatar,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'post_id' => $new_post->id,
            'post_content' => $data['post_content'],
            'post_media' => $mediaPaths ?? "",
            'post_date' => timeAgo($new_post->created_at),
            'like_count' => $new_post->like_count,
            'comment_count' => $new_post->comment_count,
            'share_count' => $new_post->share_count,
        ];
        $this->pusher->trigger('post-channel', 'post-event', $payload);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Đăng bài thành công']);
        exit;
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
        $this->pusher->trigger('delete-posts', 'delete', [
            'post_id' => $post_id
        ]);
    }
}
