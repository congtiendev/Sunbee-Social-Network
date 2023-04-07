<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class User extends BaseModel
{
	protected string $table = 'users';

	public function countAllRows()
	{
		$sql = "SELECT COUNT(*) FROM $this->table";
		$this->setQuery($sql);
		return $this->loadRow();
	}
	public function getAllUser($column = null, $order = null, $limit = null, $offset = null)
	{
		$sql = "SELECT * FROM $this->table WHERE 1";

		if ($column !== null && $order !== null) {
			$sql .= " ORDER BY $column $order";
		}
		if ($limit !== null) {
			$sql .= " LIMIT $limit";
			if ($offset !== null) {
				$sql .= " OFFSET $offset";
			}
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	public function getUserById($id)
	{
		$sql = "SELECT * FROM $this->table WHERE id = ?";
		$this->setQuery($sql);
		return $this->loadRow(array($id));
	}
	public function getUserBy($column, $value)
	{
		$sql = "SELECT * FROM $this->table WHERE $column = ?";
		$this->setQuery($sql);
		return $this->loadRow(array($value));
	}


	public function saveCreateAccount($first_name, $last_name, $username, $email, $phone_number, $role, $password)
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
		$id
	) {
		$sql = "UPDATE $this->table SET first_name = ?,last_name = ?,username = ?,email = ?,phone_number = ?,role = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($first_name, $last_name, $username, $email, $phone_number, $role, $id));
	}

	public function deleteUser($id)
	{
		$sql = "DELETE FROM $this->table WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($id));
	}

	public function changePassword($password, $id)
	{
		$sql = "UPDATE $this->table SET password = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($password, $id));
	}

	public function changeStatus($status, $id)
	{
		$sql = "UPDATE $this->table SET status = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($status, $id));
	}

	public function changeRole($role, $id)
	{
		$sql = "UPDATE $this->table SET role = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($role, $id));
	}

	public function saveUpdateProfile($first_name, $last_name, $gender, $birthday, $address, $bio, $avatar, $id)
	{
		$sql = "UPDATE $this->table SET first_name = ?, last_name = ?,gender = ?,birthday = ?,address = ?,bio = ?,avatar = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($first_name, $last_name, $gender, $birthday, $address, $bio, $avatar, $id));
	}

}