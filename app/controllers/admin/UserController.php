<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\RequestController as Request;
use App\models\User;
use App\Validation\Validator;

class UserController extends BaseController
{
	private $user;
	private $request;
	private $validator;

	public function __construct()
	{
		$this->user = new User();
		$this->request = new Request();
		$this->validator = new Validator($this->request->all());
	}

	public function renderTestValidate()
	{
		$title = "Test validate";
		$this->render("admin.user.validate", compact('title'));
	}

	public function handleRequest()
	{
		$rules = [
			'text' => 'required|active_url',
		];
		$messages = [
			'text.required' => 'Vui lòng nhập dữ liệu',
			'text.active_url' => 'Vui lòng nhập đúng định dạng url',
		];
		$errors = [];

		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (empty($errors)) {
			echo "Không có lỗi";
		} else {
			return redirect('errors', $errors, '');
		}
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
		$offset = ($page - 1) * $limit;
		$totalPages = round((int) ($totalData / $limit));
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
			return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
		}


		$rules = [
			'first_name' => 'required|alpha_unicode|min:2|max:50',
			'last_name' => 'required|alpha_unicode|min:2|max:50',
			'username' => 'required|alpha_dash|min:2|max:50|unique:users,username',
			'email' => 'required|email|min:5|max:50|unique:users,email',
			'phone_number' => 'required|phone|unique:users,phone_number',
			'password' => 'required|min:6|max:50',
			'confirm_password' => 'required|confirmed:' . $this->request->get('password'),
		];
		$messages = [
			'first_name.required' => 'Vui lòng nhập họ',
			'first_name.alpha_unicode' => 'Họ không được chứa ký tự đặc biệt và số',
			'first_name.min' => 'Họ phải có ít nhất 2 ký tự',
			'first_name.max' => 'Họ không được vượt quá 50 ký tự',

			'last_name.required' => 'Vui lòng nhập tên',
			'last_name.alpha_unicode' => 'Tên không được chứa ký tự đặc biệt và số',
			'last_name.min' => 'Tên phải có ít nhất 2 ký tự',
			'last_name.max' => 'Tên không được vượt quá 50 ký tự',

			'username.required' => 'Vui lòng nhập tên đăng nhập',
			'username.alpha_dash' => 'Tên đăng nhập không được chứa ký tự đặc biệt',
			'username.min' => 'Tên đăng nhập phải có ít nhất 5 ký tự',
			'username.max' => 'Tên đăng nhập không được vượt quá 50 ký tự',
			'username.unique' => 'Tên đăng nhập đã tồn tại',

			'email.required' => 'Vui lòng nhập email',
			'email.email' => 'Vui lòng nhập đúng định dạng email',
			'email.min' => 'Email phải có ít nhất 5 ký tự',
			'email.max' => 'Email không được vượt quá 50 ký tự',
			'email.unique' => 'Email đã tồn tại',

			'phone_number.required' => 'Vui lòng nhập số điện thoại',
			'phone_number.phone' => 'Vui lòng nhập đúng định dạng số điện thoại',
			'phone_number.unique' => 'Số điện thoại đã tồn tại',

			'password.required' => 'Vui lòng nhập mật khẩu',
			'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
			'password.max' => 'Mật khẩu không được vượt quá 50 ký tự',

			'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
			'confirm_password.confirmed' => 'Mật khẩu nhập lại không khớp',
		];
		$errors = [];

		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (!empty($errors)) {
			redirect('errors', $errors, 'admin/account/create');
		}
		$password = $this->request->get('password');
		$this->request->set('password', password_hash($password, PASSWORD_DEFAULT));
		$result = $this->user->storeCreateAccount($this->request->all());
		if ($result) {
			return redirect('success', 'Tạo mới tài khoản thành công', 'admin/account/list');
		}
	}

	public function handleUpdateAccount($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
		}


		$rules = [
			'first_name' => 'required|alpha_unicode|min:2|max:50',
			'last_name' => 'required|alpha_unicode|min:2|max:50',
			'username' => 'required|alpha_dash|min:2|max:50|unique:users,username,' . $id,
			'email' => 'required|email|min:5|max:50|unique:users,email,' . $id,
			'phone_number' => 'required|phone|unique:users,phone_number,' . $id,
		];
		$messages = [
			'first_name.required' => 'Vui lòng nhập họ',
			'first_name.alpha_unicode' => 'Họ không được chứa ký tự đặc biệt và số',
			'first_name.min' => 'Họ phải có ít nhất 2 ký tự',
			'first_name.max' => 'Họ không được vượt quá 50 ký tự',

			'last_name.required' => 'Vui lòng nhập tên',
			'last_name.alpha_unicode' => 'Tên không được chứa ký tự đặc biệt và số',
			'last_name.min' => 'Tên phải có ít nhất 2 ký tự',
			'last_name.max' => 'Tên không được vượt quá 50 ký tự',

			'username.required' => 'Vui lòng nhập tên đăng nhập',
			'username.alpha_dash' => 'Tên đăng nhập không được chứa ký tự đặc biệt',
			'username.min' => 'Tên đăng nhập phải có ít nhất 5 ký tự',
			'username.max' => 'Tên đăng nhập không được vượt quá 50 ký tự',
			'username.unique' => 'Tên đăng nhập đã tồn tại',

			'email.required' => 'Vui lòng nhập email',
			'email.email' => 'Vui lòng nhập đúng định dạng email',
			'email.min' => 'Email phải có ít nhất 5 ký tự',
			'email.max' => 'Email không được vượt quá 50 ký tự',
			'email.unique' => 'Email đã tồn tại',

			'phone_number.required' => 'Vui lòng nhập số điện thoại',
			'phone_number.phone' => 'Vui lòng nhập đúng định dạng số điện thoại',
			'phone_number.unique' => 'Số điện thoại đã tồn tại',
		];
		$errors = [];

		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (!empty($errors)) {
			redirect('errors', $errors, 'admin/account/update/' . $id);
		}
		$result = $this->user->storeUpdateAccount($this->request->all(), $id);
		if ($result) {
			return redirect('success', 'Cập nhật tài khoản thành công', 'admin/account/list');
		}
	}

	public function deleteAccount(int $id)
	{
		$this->user->deleteUser($id);
		redirect('success', 'Xóa tài khoản thành công', 'admin/account/list');
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

	public function handleUpdateProfile(int $id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
		}

		$min_age = date('Y-m-d', strtotime('-16 years', strtotime(date('Y-m-d'))));
		$rules = [
			'first_name' => 'required|alpha_unicode|min:2|max:50',
			'last_name' => 'required|alpha_unicode|min:2|max:50',
			'birthday' => 'required|before_or_equal:' . $min_age,
			'address' => 'required|min:5|max:255',
			'avatar' => 'mimes:jpeg/png/jpg/gif/svg|max:10MB',
			'bio' => 'max:255',
		];
		$messages = [
			'first_name.required' => 'Vui lòng nhập họ',
			'first_name.alpha_unicode' => 'Họ không được chứa ký tự đặc biệt và số',
			'first_name.min' => 'Họ phải có ít nhất 2 ký tự',
			'first_name.max' => 'Họ không được vượt quá 50 ký tự',

			'last_name.required' => 'Vui lòng nhập tên',
			'last_name.alpha_unicode' => 'Tên không được chứa ký tự đặc biệt và số',
			'last_name.min' => 'Tên phải có ít nhất 2 ký tự',
			'last_name.max' => 'Tên không được vượt quá 50 ký tự',

			'birthday.required' => 'Vui lòng nhập ngày sinh',
			'birthday.date' => 'Vui lòng nhập đúng định dạng ngày sinh',
			'birthday.before_or_equal' => 'Bạn phải đủ 16 tuổi để đăng ký tài khoản',

			'address.required' => 'Vui lòng nhập địa chỉ',
			'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự',
			'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

			'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif, svg',
			'avatar.max' => 'Ảnh đại diện không được vượt quá 10MB',
			'bio.max' => 'Tiểu sử không được vượt quá 255 ký tự',
		];
		$errors = [];
		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (!empty($errors)) {
			return redirect('errors', $errors, 'admin/profile/update/' . $id);
		} else {
			$avatar = $this->request->get('avatar')['name'];
			$avatar_name = $this->request->get('avatar')['tmp_name'];
			if ($avatar_name) {
				$avatar_name = uniqid('', true) . '-' . $avatar;
				move_uploaded_file($_FILES['avatar']['tmp_name'], './public/uploads/avatars/' . $avatar_name);
				if (!empty($this->user->getUserById($id)->avatar)) {
					unlink('./public/uploads/avatars/' . $this->user->getUserById($id)->avatar);
				}
			} else {
				$avatar_name = $this->user->getUserById($id)->avatar;
			}
			$this->request->set('avatar', $avatar_name);
			$result = $this->user->storeUpdateProfile($this->request->all(), $id);
			if ($result) {
				return redirect('success', 'Cập nhật thông tin cá nhân thành công', 'admin/profile/list');
			}
		}
	}

	public function renderProfile($id)
	{
		$title = "Thông tin cá nhân";
		$user = $this->user->getUserById($id);
		$this->render("admin.user.profile", compact('title', 'user'));
	}

	public function handleDeleteAvatar($id)
	{
		$avatar = $this->user->getUserById($id)->avatar;
		if (!empty($avatar)) {
			unlink('./public/uploads/avatars/' . $avatar);
		}
		$this->user->deleteAvatar($id);
		redirect('success', 'Đã xóa ảnh đại diện', 'back');
	}

	public function handleDeleteCoverPhoto($id)
	{
		$cover_photo = $this->user->getUserById($id)->cover_photo;
		if (!empty($cover_photo)) {
			unlink('./public/uploads/cover-photos/' . $cover_photo);
		}
		$this->user->deleteCoverPhoto($id);
		redirect('success', 'Đã xóa ảnh bìa', 'back');
	}

	public function handleChangeAvatar($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/profile/list');
		}
		$rules = [
			'avatar' => 'required|mimes:jpeg/png/jpg/gif/svg|max:10MB',
		];
		$messages = [
			'avatar.required' => 'Vui lòng chọn ảnh đại diện',
			'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif, svg',
			'avatar.max' => 'Ảnh đại diện không được vượt quá 10MB',
		];
		$errors = [];
		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (!empty($errors)) {
			return redirect('errors', $errors, 'admin/change-avatar/' . $id);
		} else {
			$avatar = $this->request->get('avatar')['name'];
			$avatar_name = $this->request->get('avatar')['tmp_name'];
			if ($avatar_name) {
				$avatar_name = uniqid('', true) . '-' . $avatar;
				move_uploaded_file($_FILES['avatar']['tmp_name'], './public/uploads/avatars/' . $avatar_name);
				if (!empty($this->user->getUserById($id)->avatar)) {
					unlink('./public/uploads/avatars/' . $this->user->getUserById($id)->avatar);
				}
			} else {
				$avatar_name = $this->user->getUserById($id)->avatar;
			}
			$this->request->set('avatar', $avatar_name);
			$result = $this->user->changeAvatar($avatar_name, $id);
			if ($result) {
				unset($_SESSION['old']);
				return redirect('success', 'Cập nhật ảnh đại diện thành công', 'admin/profile/list');
			}
		}
	}

	public function handleChangeCoverPhoto($id)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/profile/list');
		}

		$rules = [
			'cover_photo' => 'required|mimes:jpeg/png/jpg/gif/svg|max:10MB',
		];
		$messages = [
			'cover_photo.required' => 'Vui lòng chọn ảnh bìa',
			'cover_photo.mimes' => 'Ảnh bìa phải có định dạng jpeg, png, jpg, gif, svg',
			'cover_photo.max' => 'Ảnh bìa không được vượt quá 10MB',
		];
		$errors = [];
		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (!empty($errors)) {
			return redirect('errors', $errors, 'admin/change-cover-photo/' . $id);
		} else {
			$cover_photo = $this->request->get('cover_photo')['name'];
			$cover_photo_name = $this->request->get('cover_photo')['tmp_name'];
			if ($cover_photo_name) {
				$cover_photo_name = uniqid('', true) . '-' . $cover_photo;
				move_uploaded_file($_FILES['cover_photo']['tmp_name'], './public/uploads/cover-photos/' . $cover_photo_name);
				if (!empty($this->user->getUserById($id)->cover_photo)) {
					unlink('./public/uploads/cover-photos/' . $this->user->getUserById($id)->cover_photo);
				}
			} else {
				$cover_photo_name = $this->user->getUserById($id)->cover_photo;
			}
			$this->request->set('cover_photo', $cover_photo_name);
			$result = $this->user->changeCoverPhoto($cover_photo_name, $id);
			if ($result) {
				unset($_SESSION['old']);
				return redirect('success', 'Cập nhật ảnh bìa thành công', 'back');
			}
		}
	}

	// -----------------------------------Search user----------------------------------//
	public function searchUser()
	{
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
		if (isset($_GET['account'])) {
			$this->renderListAccount($keyword);
		}
		if (isset($_GET['profile'])) {
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

		$password = $this->user->getUserById($id)->password;
		$new_password = $this->request->get('new_password');

		$rules = [
			'password' => 'required|password:' . $password,
			'new_password' => 'required|min:6|max:32|different:' . $password,
			'confirm_password' => 'required|confirmed:' . $new_password,
		];
		$messages = [
			'password.required' => 'Vui lòng nhập mật khẩu cũ',
			'password.password' => 'Mật khẩu cũ không chính xác',
			'new_password.required' => 'Vui lòng nhập mật khẩu mới',
			'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
			'new_password.max' => 'Mật khẩu mới không được vượt quá 32 ký tự',
			'new_password.different' => 'Mật khẩu mới không được trùng với mật khẩu cũ',
			'confirm_password.required' => 'Vui lòng nhập lại mật khẩu mới',
			'confirm_password.confirmed' => 'Mật khẩu nhập lại không trùng khớp',
		];
		$errors = [];
		$this->validator->setRules($rules);
		$this->validator->setMessages($messages);
		$this->validator->Validation();
		$errors = $this->validator->getErrors();
		if (empty($errors)) {
			$result = $this->user->changePassword(password_hash($new_password, PASSWORD_DEFAULT), $id);
			if ($result) {
				return redirect('success', 'Đổi mật khẩu thành công', 'admin/account/update/' . $id);
			}
		} else {
			return redirect('errors', $errors, 'admin/change-password/' . $id);
		}
	}
}
