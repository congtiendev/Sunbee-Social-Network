<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class User extends BaseModel
{
	protected string $table = 'users';

	public function getAllUser()
	{
		$sql = "SELECT * FROM $this->table";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	public function getUserById($id)
	{
		$sql = "SELECT * FROM $this->table WHERE id = ?";
		$this->setQuery($sql);
		return $this->loadRow(array($id));
	}

	public function saveCreateUser($first_name, $last_name, $username, $email, $phone_number, $role, $password)
	{
		$sql = "INSERT INTO $this->table (first_name,last_name,username,email,phone_number,role,password) VALUES (?,?,?,?,?,?,?)";
		$this->setQuery($sql);
		return $this->execute(array($first_name, $last_name, $username, $email, $phone_number, $role, $password));
	}


	protected function checkExists($columnName, $value, $id = 0)
	{
		$sql = "SELECT * FROM $this->table WHERE $columnName = ?";
		if ($id != 0) {
			$sql .= " AND id != $id";
		}
		$this->setQuery($sql);
		$result = $this->loadRow(array($value));
		if ($result) {
			return true;
		}
		return false;
	}

	public function checkExistsUsername($username, $id = 0)
	{
		return $this->checkExists('username', $username, $id);
	}

	public function checkExistsEmail($email, $id = 0)
	{
		return $this->checkExists('email', $email, $id);
	}

	public function checkExistsPhoneNumber($phone_number, $id = 0)
	{
		return $this->checkExists('phone_number', $phone_number, $id);
	}

	public function saveUpdateAccount(
		$first_name,
		$last_name,
		$username,
		$email,
		$phone_number,
		$role,
		$password,
		$id
	) {
		$sql = "UPDATE $this->table SET first_name = ?,last_name = ?,username = ?,email = ?,phone_number = ?,role = ?,password = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($first_name, $last_name, $username, $email, $phone_number, $role, $password, $id));
	}

	public function deleteUser($id)
	{
		$sql = "DELETE FROM $this->table WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($id));
	}



}