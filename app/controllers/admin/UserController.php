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
	public function renderListUser($column = null, $order = null)
	{
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 3;
		$offset = ($page - 1) * $limit;
		$totalUsers = count($this->user->getAllUser()); //Đếm tổng số bản ghi
		$totalPages = round(intval($totalUsers / $limit)); //Tổng số trang
		$pagination = [
			'offset' => $offset,
			'total' => $totalUsers,
			'limit' => $limit,
			'current_page' => $page,
			'total_pages' => $totalPages,
		]; //Tạo mảng chứa thông tin phân trang
		if ($column !== null && $order !== null) { //Kiểm tra xem có sắp xếp hay không
			$users = $this->user->getAllUser($column, $order, $limit, $offset);
		} else { //Nếu không có sắp xếp thì lấy tất cả
			$users = $this->user->getAllUser(null, null, $limit, $offset);
		}

		if (isset($_GET['url']) && $_GET['url'] === 'list-account') {
			$title = "Danh sách tài khoản";
			$this->render("admin.user.list-account", compact('title', 'users', 'pagination'));
		} else {
			$title = "Danh sách hồ sơ";
			$this->render("admin.user.list-profile", compact('title', 'users', 'pagination'));
		}
	}

	public function renderCreateAccount(array $errors = [])
	{
		$title = "Tạo mới tài khoản";
		$this->render("admin.user.create-account", compact('title', 'errors'));
	}

	public function renderUpdateAccount(int $id, array $errors = [])
	{
		$title = "Cập nhật tài khoản";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.update-account", compact('title', 'errors', 'user'));
	}

	public function handleCreateAccount()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể tạo mới tài khoản', 'list-account');
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
		}

		if (empty($data['last_name'])) {
			$errors['last_name'] = 'Vui lòng nhập họ';
		} elseif (strlen($data['last_name']) > 50) {
			$errors['last_name'] = 'Họ không được quá 50 ký tự';
		} elseif (strlen($data['last_name']) < 2) {
			$errors['last_name'] = 'Họ không được ít hơn 2 ký tự';
		}

		if (empty($data['username'])) {
			$errors['username'] = 'Username không được để trống';
		} elseif (strlen($data['username']) > 30) {
			$errors['username'] = 'Username không được quá 20 ký tự';
		} elseif (strlen($data['username']) < 5) {
			$errors['username'] = 'Username không được ít hơn 5 ký tự';
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
			$this->user->saveCreateAccount(
				$data['first_name'],
				$data['last_name'],
				$data['username'],
				$data['email'],
				$data['phone_number'],
				$data['role'],
				$data['password']
			);
			redirect('success', 'Tạo mới tài khoản thành công', 'list-account');
		} else {
			$this->renderCreateAccount($errors);
		}
	}

	public function handleUpdateAccount($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'list-account');
		}
		$data = [
			'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) ?: '',
			'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) ?: '',
			'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?: '',
			'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?: '',
			'phone_number' => filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT) ?: '',
			'role' => filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING) ?: '',
		];
		$errors = [];
		if (empty($data['first_name'])) {
			$errors['first_name'] = 'Vui lòng nhập tên';
		} elseif (strlen($data['first_name']) > 50) {
			$errors['first_name'] = 'Tên không được quá 50 ký tự';
		} elseif (strlen($data['first_name']) < 2) {
			$errors['first_name'] = 'Tên không được ít hơn 2 ký tự';
		}

		if (empty($data['last_name'])) {
			$errors['last_name'] = 'Vui lòng nhập họ';
		} elseif (strlen($data['last_name']) > 50) {
			$errors['last_name'] = 'Họ không được quá 50 ký tự';
		} elseif (strlen($data['last_name']) < 2) {
			$errors['last_name'] = 'Họ không được ít hơn 2 ký tự';
		}

		if (empty($data['username'])) {
			$errors['username'] = 'Username không được để trống';
		} elseif (strlen($data['username']) > 30) {
			$errors['username'] = 'Username không được quá 20 ký tự';
		} elseif (strlen($data['username']) < 5) {
			$errors['username'] = 'Username không được ít hơn 5 ký tự';
		} elseif ($this->user->checkExistsUsername($data['username'], $id)) {
			$errors['username'] = 'Username đã tồn tại';
		}

		if (empty($data['email'])) {
			$errors['email'] = 'Email không được để trống';
		} elseif (strlen($data['email']) > 50) {
			$errors['email'] = 'Email không được quá 50 ký tự';
		} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Email không đúng định dạng';
		} elseif ($this->user->checkExistsEmail($data['email'], $id)) {
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
		} elseif ($this->user->checkExistsPhoneNumber($data['phone_number'], $id)) {
			$errors['phone_number'] = 'Số điện thoại đã tồn tại';
		}

		if ($data['role'] === '') {
			$errors['role'] = 'Vui lòng chọn quyền';
		}
		if (count($errors) > 0) {
			$this->renderUpdateAccount($id, $errors);
		} else {
			$this->user->saveUpdateAccount(
				$data['first_name'],
				$data['last_name'],
				$data['username'],
				$data['email'],
				$data['phone_number'],
				$data['role'],
				$id
			);
			redirect('success', 'Cập nhật tài khoản thành công', 'list-account');
		}
	}

	public function deleteAccount(int $id)
	{
		$this->user->deleteUser($id);
		redirect('success', 'Xóa tài khoản thành công', 'list-account');
	}

	public function handleSortAccount()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'list-account');
		}
		if ($_POST['sort_account'] == 'sort_by_name') {
			$column = 'first_name';
			$order = 'ASC';
			return redirect('', 'Săps xếp theo tên', 'list-account/' . $column . '/' . $order);
		} elseif ($_POST['sort_account'] == 'sort_by_latest') {
			$column = 'created_at';
			$order = 'DESC';
			return redirect('', 'Săps xếp theo ngày tạo mới nhất', 'list-account/' . $column . '/' . $order);
		} elseif ($_POST['sort_account'] == 'sort_by_oldest') {
			$column = 'created_at';
			$order = 'ASC';
			return redirect('', 'Sắp xếp theo ngày tạo muộn nhất', 'list-account/' . $column . '/' . $order);
		} else {
			return redirect('', 'Danh sách tài khoản', 'list-account');
		}
	}


	// --------------------------------------Profile---------------------------------------//
	public function renderUpdateProfile(int $id, array $errors = [])
	{
		$title = "Cập nhật thông tin cá nhân";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.update-profile", compact('title', 'errors', 'user'));
	}

	public function handleUpdateProfile($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'list-profile');
		}
		$data = [
			'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) ?: '',
			'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) ?: '',
			'gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING) ?: '',
			'birthday' => filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING) ?: '',
			'address' => filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) ?: '',
			'bio' => filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING) ?: '',
		];
		$avatar = $_FILES['avatar']['name'];
		$avatar_name = $_FILES['avatar']['tmp_name'];
		if ($avatar_name) {
			$avatar_name = uniqid('', true) . '-' . $avatar;
			move_uploaded_file($_FILES['avatar']['tmp_name'], './public/uploads/avatar/' . $avatar_name);
		} else {
			$avatar_name = $this->user->getUserById($id)->avatar;
		}
		$errors = [];
		$this->user->saveUpdateProfile($data['first_name'], $data['last_name'], $data['gender'], $data['birthday'], $data['address'], $data['bio'], $avatar_name, $id);
		redirect('success', 'Cập nhật thông tin cá nhân thành công', 'list-profile');
	}
}