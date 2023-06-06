<?php

namespace App\Models;

class Auth extends BaseModel
{
    private string $table = 'users';

    public function register($data)
    {
        $sql = "INSERT INTO $this->table (first_name, last_name,username, email, password) VALUES (?, ?, ?, ?, ?)";
        $this->setQuery($sql);
        return $this->execute([
            $data['first_name'],
            $data['last_name'],
            $data['username'],
            $data['email'],
            $data['password'],
        ]);
    }

    public function login($data)
    {
        $sql = "SELECT * FROM $this->table WHERE (email = ? OR phone_number = ? OR username = ?) AND password = ?";
        $this->setQuery($sql);
        return $this->loadRow([
            $data['account'],
            $data['account'],
            $data['account'],
            $data['password'],
        ]);
    }

    public function getAccount($account)
    {
        $sql = "SELECT * FROM $this->table WHERE email = ? OR phone_number = ? OR username = ?";
        $this->setQuery($sql);
        return $this->loadRow([
            $account,
            $account,
            $account,
        ]);
    }



    public function checkRole($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ? AND role = 1";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }




}