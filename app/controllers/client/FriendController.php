<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Controllers\RequestController;
use App\Models\Friend;
use Pusher;


class FriendController extends BaseController
{
    private $friend;
    private $request;
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
        $this->friend = new Friend();
        $this->request = new RequestController();
        $this->pusher = new Pusher\Pusher(
            PUSHER_APP_KEY,
            PUSHER_APP_SECRET,
            PUSHER_APP_ID,
            $this->options
        );
    }

    public function listFriends()
    {
        $user_id = $_SESSION['auth']->id;
        $friends = $this->friend->getFriendList($user_id);
        echo "<pre>";
        var_dump($friends);
        echo "</pre>";
        die();
    }
}
