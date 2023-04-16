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

	public function renderListAccount($keyword = null, $column = null, $order = null)
	{
		$title = "Danh sách tài khoản";
		$users = $this->user->getAllUser($keyword, $this->Pagination()['limit'], $this->Pagination()['offset'], $column, $order);
		$pagination = $this->Pagination();
		$this->render("admin.user.list-account", compact('title', 'users', 'keyword', 'pagination'));
	}
	public function Pagination()
	{
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$totalData = count($this->user->getAllUser());
		$offset = ($page - 1) * $limit; //Vị trí bắt đầu lấy dữ liệu
		$totalPages = round(intval($totalData / $limit));
		return [
			'offset' => $offset,
			'total' => $totalData,
			'limit' => $limit,
			'current_page' => $page,
			'total_pages' => $totalPages,
		];
	}

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
			return redirect('errors', 'Không thể tạo mới tài khoản', 'admin/list-account');
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
		$_SESSION['valid_data'] = $data; //Lưu dữ liệu đã nhập vào session để hiển thị lại khi có lỗi
		//Xóa khoảng trắng ở đầu và cuối chuỗi
		foreach ($data as $key => $value) {
			$data[$key] = trim($value);
			$_SESSION['valid_data'][$key] = trim($value);
		}
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
		} elseif ($this->user->checkExistsUsername(trim($data['username']))) {
			$errors['username'] = 'Username đã tồn tại';
		}

		if (empty($data['email'])) {
			$errors['email'] = 'Email không được để trống';
		} elseif (strlen($data['email']) > 50) {
			$errors['email'] = 'Email không được quá 50 ký tự';
		} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Email không đúng định dạng';
		} elseif ($this->user->checkExistsEmail(trim($data['email']))) {
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
		} elseif ($this->user->checkExistsPhoneNumber(trim($data['phone_number']))) {
			$errors['phone_number'] = 'Số điện thoại đã tồn tại';
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
			$result = $this->user->saveCreateAccount(
				$data['first_name'],
				$data['last_name'],
				$data['username'],
				$data['email'],
				$data['phone_number'],
				$data['role'],
				password_hash($data['password'], PASSWORD_DEFAULT)
			);
			if ($result) {
				unset($_SESSION['valid_data']);
				redirect('success', 'Tạo mới tài khoản thành công', 'admin/list-account');
			}
		} else {
			redirect('errors', $errors, 'admin/create-account');
		}
	}

	public function handleUpdateAccount($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/list-account');
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
		$_SESSION['valid_data'] = $data; //Lưu dữ liệu đã nhập vào session để hiển thị lại khi có lỗi
		//Xóa khoảng trắng ở đầu và cuối chuỗi
		foreach ($data as $key => $value) {
			$data[$key] = trim($value);
			$_SESSION['valid_data'][$key] = trim($value);
		}

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
		} elseif ($this->user->checkExistsUsername(trim($data['username']), $id)) {
			$errors['username'] = 'Username đã tồn tại';
		} else {
			$validData['username'] = $_SESSION['valid_data']['username'];
		}

		if (empty($data['email'])) {
			$errors['email'] = 'Email không được để trống';
		} elseif (strlen($data['email']) > 50) {
			$errors['email'] = 'Email không được quá 50 ký tự';
		} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Email không đúng định dạng';
		} elseif ($this->user->checkExistsEmail(trim($data['email']), $id)) {
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
		} elseif ($this->user->checkExistsPhoneNumber(trim($data['phone_number']), $id)) {
			$errors['phone_number'] = 'Số điện thoại đã tồn tại';
		}

		if (count($errors) > 0) {
			redirect('errors', $errors, 'admin/update-account/' . $id);
		} else {
			$this->user->saveUpdateAccount(
				trim($data['first_name']),
				trim($data['last_name']),
				trim($data['username']),
				trim($data['email']),
				trim($data['phone_number']),
				trim($data['role']),
				$id
			);
			unset($_SESSION['valid_data']);
			redirect('success', 'Cập nhật tài khoản thành công', 'admin/list-account');
		}
	}

	public function deleteAccount(int $id)
	{
		$this->user->deleteUser($id);
		redirect('success', 'Xóa tài khoản thành công', 'admin/list-account');
	}
	// --------------------------------------Profile---------------------------------------//
	public function renderListProfile($keyword = null, $column = null, $order = null)
	{
		$title = "Danh sách hồ sơ";
		$users = $this->user->getAllUser($keyword, $this->Pagination()['limit'], $this->Pagination()['offset'], $column, $order);
		$pagination = $this->Pagination();
		$this->render("admin.user.list-profile", compact('title', 'users', 'keyword', 'pagination'));
	}
	public function renderUpdateProfile(int $id)
	{
		$title = "Cập nhật thông tin cá nhân";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.update-profile", compact('title', 'user'));
	}

	public function handleUpdateProfile($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/list-profile');
		}
		$data = [
			'first_name' => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) ?: '',
			'last_name' => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) ?: '',
			'gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING) ?: '',
			'birthday' => filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING) ?: '',
			'address' => filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) ?: '',
			'bio' => filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING) ?: '',
		];
		$errors = [];
		$_SESSION['valid_data'] = $data;
		//Xóa khoảng trắng ở đầu và cuối chuỗi
		foreach ($data as $key => $value) {
			$data[$key] = trim($value);
			$_SESSION['valid_data'][$key] = trim($value);
		}

		//Kiểm tra dữ liệu nhập vào
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

		if (empty($data['birthday'])) {
			$errors['birthday'] = 'Vui lòng nhập ngày sinh';
		} elseif (strtotime($data['birthday']) > strtotime(date('d-m-Y'))) {
			$errors['birthday'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
		}

		if (empty($data['address'])) {
			$errors['address'] = 'Vui lòng nhập địa chỉ';
		} elseif (strlen($data['address']) > 255) {
			$errors['address'] = 'Địa chỉ không được quá 255 ký tự';
		} elseif (strlen($data['address']) < 2) {
			$errors['address'] = 'Địa chỉ không được ít hơn 2 ký tự';
		}

		$avatar = $_FILES['avatar']['name'];
		$avatar_name = $_FILES['avatar']['tmp_name'];
		if ($avatar_name) {
			$avatar_name = uniqid('', true) . '-' . $avatar;
			move_uploaded_file($_FILES['avatar']['tmp_name'], './public/uploads/avatars/' . $avatar_name);
		} else {
			$avatar_name = $this->user->getUserById($id)->avatar;
		}
		if (empty($errors)) {
			unset($_SESSION['valid_data']);
			$this->user->saveUpdateProfile($data['first_name'], $data['last_name'], $data['gender'], $data['birthday'], $data['address'], $data['bio'], $avatar_name, $id);
			redirect('success', 'Cập nhật thông tin cá nhân thành công', 'admin/list-profile');
		} else {
			redirect('errors', $errors, 'admin/update-profile/' . $id);
		}
	}

	public function renderDetailProfile($id)
	{
		$title = "Thông tin cá nhân";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.detail-profile", compact('title', 'user'));
	}


	// -----------------------------------Search user----------------------------------//
	public function searchUser()
	{
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
		if (isset($_GET['account'])) {
			$this->renderListAccount($keyword);
		} elseif (isset($_GET['profile'])) {
			$this->renderListProfile($keyword);
		}
	}

	// ----------------------------------Change password----------------------------------//
	public function renderChangePassword(int $id, array $errors = [])
	{
		$title = "Đổi mật khẩu";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.change-password", compact('title', 'errors', 'user'));
	}

	public function handleChangePassword($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
		}
		$data = [
			'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?: '',
			'new_password' => filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING) ?: '',
			'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING) ?: '',
		];

		$_SESSION['valid_data'] = $data; //Lưu dữ liệu đã nhập vào session để hiển thị lại khi có lỗi
		//Xóa khoảng trắng ở đầu và cuối chuỗi
		foreach ($data as $key => $value) {
			$data[$key] = trim($value);
			$_SESSION['valid_data'][$key] = trim($value);
		}
		if (empty($data['password'])) {
			$errors['password'] = 'Mật khẩu không được để trống';
		} elseif (!password_verify($data['password'], $this->user->getUserById($id)->password)) {
			$errors['password'] = 'Mật khẩu không đúng';
		} else {
			$password_valid = true;
		}
		if (empty(trim($data['new_password']))) {
			$errors['new_password'] = 'Vui lòng nhập mật khẩu mới của bạn !';
		} elseif (strlen(trim($data['new_password'])) < 6) {
			$errors['new_password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
		} elseif (strlen(trim($data['new_password'])) > 20) {
			$errors['new_password'] = 'Mật khẩu không được quá 20 ký tự';
		} else if (password_verify($data['new_password'], $this->user->getUserById($id)->password) && $password_valid) {
			$errors['new_password'] = 'Mật khẩu mới không được trùng với mật khẩu cũ';
		}

		if (empty($data['confirm_password'])) {
			$errors['confirm_password'] = 'Vui lòng nhập lại mật khẩu mới của bạn !';
		} elseif ($data['new_password'] !== $data['confirm_password']) {
			$errors['confirm_password'] = 'Mật khẩu nhập lại không khớp';
		}
		if (empty($errors)) {
			$result = $this->user->changePassword(password_hash($data['new_password'], PASSWORD_DEFAULT), $id);
			if ($result) {
				unset($_SESSION['valid_data']);
				redirect('success', 'Đổi mật khẩu thành công', 'update-account/' . $id);
			}
		} else {
			redirect('errors', $errors, 'change-password/' . $id);
		}

	}



}