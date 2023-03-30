<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\User;
use Exception;

class UserController extends BaseController
{
	protected $user;

	public function __construct()
	{
		$this->user = new User();
	}

	/**
	 * @throws Exception
	 */
	public function listAccounts()
	{
		$title = "Danh sách tài khoản";
		$users = $this->user->getAllUser();
		$this->render("admin.user.list-account", compact('title', 'users'));
	}

	/**
	 * @throws Exception
	 */
	public function renderCreateAccount()
	{
		$title = "Tạo mới tài khoản";
		$this->render("admin.user.create-account", compact('title'));
	}

	public function renderUpdateAccount(int $id)
	{
		$title = "Cập nhật tài khoản";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.update-account", compact('title', 'user'));
	}

	public function handleCreateAccount()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể tạo mới tài khoản', 'list-accounts');
		}
		$data = [
			'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) ?: '',
			'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) ?: '',
			'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?: '',
			'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?: '',
			'phone_number' => filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT) ?: '',
			'role' => filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING) ?: '',
			'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?: '',
			'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING) ?: '',
		];
		$errors = [];
		if (empty($data['first_name'])) {
			$errors['first_name'] = 'Vui lòng nhập tên';
		} elseif (strlen($data['first_name']) > 50) {
			$errors['first_name'] = 'Tên không được quá 50 ký tự';
		} elseif (strlen($data['first_name']) < 2) {
			$errors['first_name'] = 'Tên không được ít hơn 2 ký tự';
		} elseif (!preg_match('/^[a-zA-Z ]*$/', $data['first_name'])) {
			$errors['first_name'] = 'Tên không được chứa ký tự đặc biệt';
		}

		if (empty($data['last_name'])) {
			$errors['last_name'] = 'Vui lòng nhập họ';
		} elseif (strlen($data['last_name']) > 50) {
			$errors['last_name'] = 'Họ không được quá 50 ký tự';
		} elseif (strlen($data['last_name']) < 2) {
			$errors['last_name'] = 'Họ không được ít hơn 2 ký tự';
		} elseif (!preg_match('/^[a-zA-Z ]*$/', $data['last_name'])) {
			$errors['last_name'] = 'Họ không được chứa ký tự đặc biệt';
		}

		if (empty($data['username'])) {
			$errors['username'] = 'Username không được để trống';
		} elseif (strlen($data['username']) > 30) {
			$errors['username'] = 'Username không được quá 20 ký tự';
		} elseif (strlen($data['username']) < 5) {
			$errors['username'] = 'Username không được ít hơn 5 ký tự';
		} elseif (!preg_match('/^[a-zA-Z0-9]*$/', $data['username'])) {
			$errors['username'] = 'Username không được chứa ký tự đặc biệt';
		} elseif ($this->user->checkExistsUsername($data['username'])) {
			$errors['username'] = 'Username đã tồn tại';
		}

		if (empty($data['email'])) {
			$errors['email'] = 'Email không được để trống';
		} elseif (strlen($data['email']) > 50) {
			$errors['email'] = 'Email không được quá 50 ký tự';
		} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Email không đúng định dạng';
		} elseif ($this->user->checkExistsEmail($data['email'])) {
			$errors['email'] = 'Email đã tồn tại';
		}

		if (empty($data['phone_number'])) {
			$errors['phone_number'] = 'Số điện thoại không được để trống';
		} elseif (strlen($data['phone_number']) > 11) {
			$errors['phone_number'] = 'Số điện thoại không được quá 11 ký tự';
		} elseif (strlen($data['phone_number']) < 10) {
			$errors['phone_number'] = 'Số điện thoại không được ít hơn 10 ký tự';
		} elseif (!preg_match('/^[0-9]*$/', $data['phone_number'])) {
			$errors['phone_number'] = 'Số điện thoại không được chứa ký tự đặc biệt';
		} elseif ($this->user->checkExistsPhoneNumber($data['phone_number'])) {
			$errors['phone_number'] = 'Số điện thoại đã tồn tại';
		}

		if ($data['role'] === '') {
			$errors['role'] = 'Vui lòng chọn quyền';
		}

		if (empty($data['password'])) {
			$errors['password'] = "Vui lòng nhập mật khẩu";
		} elseif (strlen($data['password']) < 6) {
			$errors['password'] = "Mật khẩu không được ít hơn 6 ký tự";
		} elseif (strlen($data['password']) > 20) {
			$errors['password'] = "Mật khẩu không được quá 20 ký tự";
		}

		if (empty($data['confirm_password'])) {
			$errors['confirm_password'] = "Vui lòng nhập lại mật khẩu";
		} elseif ($data['password'] !== $data['confirm_password']) {
			$errors['confirm_password'] = "Mật khẩu không khớp";
		}

		if (empty($errors)) {
			$this->user->saveCreateUser(
				$data['first_name'],
				$data['last_name'],
				$data['username'],
				$data['email'],
				$data['phone_number'],
				$data['role'],
				$data['password']
			);
			redirect('success', 'Tạo mới tài khoản thành công', 'list-accounts');
		} else {
			$title = "Tạo mới tài khoản";
			$this->render("admin.user.create-account", compact('title', 'errors'));
		}
	}

	public function handleUpdateAccount(int $id)
	{
		if (!isset($_POST['btn-save'])) {
			return redirect('errors', 'Không thể cập nhật tài khoản', 'list-accounts');
		}
		$data = [
			'first_name' => $_POST['first_name'] ?? '',
			'last_name' => $_POST['last_name'] ?? '',
			'username' => $_POST['username'] ?? '',
			'email' => $_POST['email'] ?? '',
			'phone_number' => $_POST['phone_number'] ?? '',
			'role' => $_POST['role'] ?? '',
		];
		$this->user->saveUpdateAccount(
			$data['first_name'],
			$data['last_name'],
			$data['username'],
			$data['email'],
			$data['phone_number'],
			$data['role'],
			$_POST['password'],
			$id
		);
	}

	public function deleteAccount(int $id)
	{
		$this->user->deleteUser($id);
		redirect('success', 'Xóa tài khoản thành công', 'list-accounts');
	}
}