<?php

namespace App\Models;

class Friend extends BaseModel
{
    protected $friends = 'friends';
    protected $users = 'users';

    public function getFriendList($user_id)
    {
        // $sql = "SELECT * FROM $this->friends
        //         INNER JOIN $this->users
        //         ON $this->friends.friend_id = $this->users.id
        //         WHERE $this->friends.user_id = $user_id AND $this->friends.status = 1 UNION SELECT * FROM $this->friends INNER JOIN $this->users ON $this->friends.user_id = $this->users.id WHERE $this->friends.friend_id = $user_id AND $this->friends.status = 1";
        $sql = "SELECT $this->users.id,$this->users.username,$this->users.avatar,$this->users.first_name,$this->users.last_name,$this->friends.status FROM $this->friends
                INNER JOIN $this->users
                ON $this->friends.friend_id = $this->users.id
                WHERE $this->friends.user_id = $user_id AND $this->friends.status = 1 UNION SELECT $this->users.id,$this->users.username,$this->users.avatar,$this->users.first_name,$this->users.last_name,$this->friends.status FROM $this->friends INNER JOIN $this->users ON $this->friends.user_id = $this->users.id WHERE $this->friends.friend_id = $user_id AND $this->friends.status = 1";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    public function addFriend($user_id, $friend_id)
    {
        $sql = "INSERT INTO $this->friends(user_id, friend_id, status) VALUES(?,?,?)";
        $this->setQuery($sql);
        return $this->execute([$user_id, $friend_id, 0]);
    }

    public function acceptFriend($user_id, $friend_id)
    {
        $sql = "UPDATE $this->friends SET status = 1 WHERE user_id = ? AND friend_id = ?";
        $this->setQuery($sql);
        return $this->execute([$user_id, $friend_id]);
    }

    public function deleteFriend($user_id, $friend_id)
    {
        $sql = "DELETE FROM $this->friends WHERE user_id = ? AND friend_id = ?";
        $this->setQuery($sql);
        return $this->execute([$user_id, $friend_id]);
    }

    //Kiểm tra xem đã gửi lời mời kết bạn chưa
    public function checkFriend($user_id, $friend_id)
    {
        $sql = "SELECT * FROM $this->friends WHERE user_id = ? AND friend_id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$user_id, $friend_id]);
    }

    //Kiểm tra xem đã là bạn bè chưa
    public function checkFriendStatus($user_id, $friend_id)
    {
        $sql = "SELECT * FROM $this->friends WHERE user_id = ? AND friend_id = ? AND status = 1";
        $this->setQuery($sql);
        return $this->loadRow([$user_id, $friend_id]);
    }

    //Đếm số lượng bạn bè
    public function countFriend($user_id)
    {
        $sql = "SELECT COUNT(*) FROM $this->friends WHERE user_id = ? AND status = 1";
        $this->setQuery($sql);
        return $this->loadRow([$user_id]);
    }
}
