<?php

namespace App\Models;

class User extends BaseModel
{
	protected string $table = 'users';


	public function getAllUser($keyword = null, $limit = null, $offset = null, $column = null, $order = null)
	{
		$sql = "SELECT * FROM $this->table WHERE 1";

		if ($limit !== null) {
			$sql .= " LIMIT $limit";
			if ($offset !== null) {
				$sql .= " OFFSET $offset";
			}
		}
		if ($keyword !== null) {
			$sql .= " AND (first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR username LIKE '%$keyword%' OR email LIKE '%$keyword%' OR phone_number LIKE '%$keyword%')";
		}
		if ($column !== null && $order !== null) {
			$sql .= " ORDER BY $column $order";
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


	public function getUserBy(string $column, int $id = null, string $value)
	{
		$sql = "SELECT * FROM $this->table";
		if ($id !== null) {
			$sql .= " WHERE $column = ? AND id != $id";
		} else {
			$sql .= " WHERE $column = ?";
		}
		$this->setQuery($sql);
		return $this->loadRow(array($value));
	}


	public function storeCreateAccount($request)
	{
		$sql = "INSERT INTO $this->table (first_name, last_name, username, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$this->setQuery($sql);
		return $this->execute(array($request['first_name'], $request['last_name'], $request['username'], $request['email'], $request['phone_number'], $request['password'], $request['role']));
	}


	public function changeAvatar($avatar, $id)
	{
		$sql = "UPDATE $this->table SET avatar = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($avatar, $id));
	}

	public function deleteAvatar($id)
	{
		$sql = "UPDATE $this->table SET avatar = null WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($id));
	}


	public function changeCoverPhoto($cover_photo, $id)
	{
		$sql = "UPDATE $this->table SET cover_photo = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($cover_photo, $id));
	}

	public function deleteCoverPhoto($id)
	{
		$sql = "UPDATE $this->table SET cover_photo = null WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($id));
	}

	public function storeUpdateAccount($request, $id)
	{
		$sql = "UPDATE $this->table SET first_name = ?, last_name = ?, username = ?, email = ?, phone_number = ?, role = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($request['first_name'], $request['last_name'], $request['username'], $request['email'], $request['phone_number'], $request['role'], $id));
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

	public function storeUpdateProfile($request, $id)
	{
		$sql = "UPDATE $this->table SET first_name = ?, last_name = ?,gender = ?,birthday = ?,address = ?,bio = ?,avatar = ? WHERE id = ?";
		$this->setQuery($sql);
		return $this->execute(array($request['first_name'], $request['last_name'], $request['gender'], $request['birthday'], $request['address'], $request['bio'], $request['avatar'], $id));
	}
}
