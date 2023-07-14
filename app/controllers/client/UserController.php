<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Controllers\RequestController;
use App\Models\User;
use App\Models\Post;
use App\Models\Friend;
use Pusher;

class UserController extends BaseController
{
    private $user;
    private $post;
    private $friend;
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
        $this->user = new User();
        $this->post = new Post();
        $this->friend = new Friend();
        $this->request = new RequestController();
        $this->pusher = new Pusher\Pusher(
            PUSHER_APP_KEY,
            PUSHER_APP_SECRET,
            PUSHER_APP_ID,
            $this->options
        );
    }

    public function renderProfile($username)
    {
        $user = $this->user->getUserBy('username', null, $username);
        $posts = $this->post->getPostBy('user_id', $user->id);
        $friends = $this->friend->getFriendList($user->id);
        $medias = $this->post->getPostMediaByUserId($user->id);
        foreach ($posts as $post) {
            $postID = $post->post_id;
            $post->medias = $this->post->getPostMedia($postID);
            $post->comments = $this->post->getPostComment($postID);
            $post->is_liked = $this->post->isLiked($postID, $user->id);
            $post->is_saved = $this->post->isSaved($postID, $user->id);
        }
        $this->render('client.profile', compact('user', 'posts', 'friends', 'medias'));
    }
}
