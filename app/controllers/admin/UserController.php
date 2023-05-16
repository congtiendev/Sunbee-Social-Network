<?php
	
	namespace App\Controllers\Admin;
	
	use App\Controllers\BaseController;
	use App\Controllers\RequestController as Request;
	use App\Models\Admin\User;
	use App\Validation\Validator;
	use App\Models\BaseModel;
	use Exception;
	
	class UserController extends BaseController
	{
		protected $user;
		protected $request;
		protected $validator;
		
		
		
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
			$users = $this->user->getAllUser($keyword, $this->Pagination()[ 'limit' ], $this->Pagination()[ 'offset' ], $column, $order);
			$pagination = $this->Pagination();
			$this->render("admin.user.list-account", compact('title', 'users', 'keyword', 'pagination'));
		}
		
		public function Pagination()
		{
			$page = isset($_GET[ 'page' ]) ? (int)$_GET[ 'page' ] : 1;
			$limit = 10;
			$totalData = count($this->user->getAllUser());
			$offset = ($page - 1) * $limit; //Vị trí bắt đầu lấy dữ liệu
			$totalPages = round((int)($totalData / $limit));
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
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
				return redirect('errors', 'Không thể tạo mới tài khoản', 'admin/list-account');
			}
			
			$_SESSION[ 'valid_data' ] = $this->request->all();
			
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
			if (empty($errors)) {
				$result = $this->user->storeCreateAccount($this->request->all());
				if ($result) {
					unset($_SESSION[ 'valid_data' ]);
					return redirect('success', 'Tạo mới tài khoản thành công', 'admin/list-account');
				}
			} else {
				redirect('errors', $errors, 'admin/create-account');
			}
		}
		
		public function handleUpdateAccount($id)
		{
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
				return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/list-account');
			}
			
			$_SESSION[ 'valid_data' ] = $this->request->all();
			
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
			if (empty($errors)) {
				$result = $this->user->storeUpdateAccount($this->request->all(), $id);
				if ($result) {
					unset($_SESSION[ 'valid_data' ]);
					return redirect('success', 'Cật nhật tài khoản thành công', 'admin/list-account');
				}
			} else {
				redirect('errors', $errors, 'admin/update-account/' . $id);
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
			$users = $this->user->getAllUser($keyword, $this->Pagination()[ 'limit' ], $this->Pagination()[ 'offset' ], $column, $order);
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
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
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
			$_SESSION[ 'valid_data' ] = $data;
			//Xóa khoảng trắng ở đầu và cuối chuỗi
			foreach ($data as $key => $value) {
				$data[ $key ] = trim($value);
				$_SESSION[ 'valid_data' ][ $key ] = trim($value);
			}
			
			//Kiểm tra dữ liệu nhập vào
			if (empty($data[ 'first_name' ])) {
				$errors[ 'first_name' ] = 'Vui lòng nhập tên';
			} elseif (strlen($data[ 'first_name' ]) > 50) {
				$errors[ 'first_name' ] = 'Tên không được quá 50 ký tự';
			} elseif (strlen($data[ 'first_name' ]) < 2) {
				$errors[ 'first_name' ] = 'Tên không được ít hơn 2 ký tự';
			}
			
			if (empty($data[ 'last_name' ])) {
				$errors[ 'last_name' ] = 'Vui lòng nhập họ';
			} elseif (strlen($data[ 'last_name' ]) > 50) {
				$errors[ 'last_name' ] = 'Họ không được quá 50 ký tự';
			} elseif (strlen($data[ 'last_name' ]) < 2) {
				$errors[ 'last_name' ] = 'Họ không được ít hơn 2 ký tự';
			}
			
			if (empty($data[ 'birthday' ])) {
				$errors[ 'birthday' ] = 'Vui lòng nhập ngày sinh';
			} elseif (strtotime($data[ 'birthday' ]) > strtotime(date('d-m-Y'))) {
				$errors[ 'birthday' ] = 'Ngày sinh không được lớn hơn ngày hiện tại';
			}
			
			if (empty($data[ 'address' ])) {
				$errors[ 'address' ] = 'Vui lòng nhập địa chỉ';
			} elseif (strlen($data[ 'address' ]) > 255) {
				$errors[ 'address' ] = 'Địa chỉ không được quá 255 ký tự';
			} elseif (strlen($data[ 'address' ]) < 2) {
				$errors[ 'address' ] = 'Địa chỉ không được ít hơn 2 ký tự';
			}
			
			$avatar = $_FILES[ 'avatar' ][ 'name' ];
			$avatar_name = $_FILES[ 'avatar' ][ 'tmp_name' ];
			if ($avatar_name) {
				$avatar_name = uniqid('', true) . '-' . $avatar;
				move_uploaded_file($_FILES[ 'avatar' ][ 'tmp_name' ], './public/uploads/avatars/' . $avatar_name);
			} else {
				$avatar_name = $this->user->getUserById($id)->avatar;
			}
			if (empty($errors)) {
				unset($_SESSION[ 'valid_data' ]);
				$this->user->saveUpdateProfile($data[ 'first_name' ], $data[ 'last_name' ], $data[ 'gender' ], $data[ 'birthday' ], $data[ 'address' ], $data[ 'bio' ], $avatar_name, $id);
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
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
				return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/list-profile');
			}
			$avatar = $_FILES[ 'avatar' ][ 'name' ];
			$avatar_name = $_FILES[ 'avatar' ][ 'tmp_name' ];
			if ($avatar_name) {
				$avatar_name = uniqid('', true) . '-' . $avatar;
				move_uploaded_file($_FILES[ 'avatar' ][ 'tmp_name' ], './public/uploads/avatars/' . $avatar_name);
				$old_avatar = $this->user->getUserById($id)->avatar;
				if (!empty($old_avatar)) {
					unlink('./public/uploads/avatars/' . $old_avatar);
				}
			} else {
				$avatar_name = $this->user->getUserById($id)->avatar;
			}
			$this->user->changeAvatar($avatar_name, $id);
			redirect('success', 'Cập nhật ảnh đại diện thành công', 'back');
		}
		
		public function handleChangeCoverPhoto($id)
		{
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
				return redirect('errors', 'Không thể thực hiện thao tác này', 'admin/list-profile');
			}
			$cover_photo = $_FILES[ 'cover_photo' ][ 'name' ];
			$cover_photo_name = $_FILES[ 'cover_photo' ][ 'tmp_name' ];
			if ($cover_photo_name) {
				$cover_photo_name = uniqid('', true) . '-' . $cover_photo;
				move_uploaded_file($_FILES[ 'cover_photo' ][ 'tmp_name' ], './public/uploads/cover-photos/' . $cover_photo_name);
				$old_cover_photo = $this->user->getUserById($id)->cover_photo;
				if (!empty($old_cover_photo)) {
					unlink('./public/uploads/cover-photos/' . $old_cover_photo);
				}
			} else {
				$cover_photo_name = $this->user->getUserById($id)->cover_photo;
			}
			$this->user->changeCoverPhoto($cover_photo_name, $id);
			redirect('success', 'Cập nhật ảnh bìa thành công', 'back');
		}
		
		
		// -----------------------------------Search user----------------------------------//
		public function searchUser()
		{
			$keyword = isset($_GET[ 'keyword' ]) ? $_GET[ 'keyword' ] : null;
			if (isset($_GET[ 'account' ])) {
				$this->renderListAccount($keyword);
			} elseif (isset($_GET[ 'profile' ])) {
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
			if ($_SERVER[ 'REQUEST_METHOD' ] !== 'POST') {
				return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
			}
			$data = [
				'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?: '',
				'new_password' => filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING) ?: '',
				'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING) ?: '',
			];
			
			$_SESSION[ 'valid_data' ] = $data; //Lưu dữ liệu đã nhập vào session để hiển thị lại khi có lỗi
			//Xóa khoảng trắng ở đầu và cuối chuỗi
			foreach ($data as $key => $value) {
				$data[ $key ] = trim($value);
				$_SESSION[ 'valid_data' ][ $key ] = trim($value);
			}
			if (empty($data[ 'password' ])) {
				$errors[ 'password' ] = 'Mật khẩu không được để trống';
			} elseif (!password_verify($data[ 'password' ], $this->user->getUserById($id)->password)) {
				$errors[ 'password' ] = 'Mật khẩu không đúng';
			} else {
				$password_valid = true;
			}
			if (empty(trim($data[ 'new_password' ]))) {
				$errors[ 'new_password' ] = 'Vui lòng nhập mật khẩu mới của bạn !';
			} elseif (strlen(trim($data[ 'new_password' ])) < 6) {
				$errors[ 'new_password' ] = 'Mật khẩu phải có ít nhất 6 ký tự';
			} elseif (strlen(trim($data[ 'new_password' ])) > 20) {
				$errors[ 'new_password' ] = 'Mật khẩu không được quá 20 ký tự';
			} else if (password_verify($data[ 'new_password' ], $this->user->getUserById($id)->password) && $password_valid) {
				$errors[ 'new_password' ] = 'Mật khẩu mới không được trùng với mật khẩu cũ';
			}
			
			if (empty($data[ 'confirm_password' ])) {
				$errors[ 'confirm_password' ] = 'Vui lòng nhập lại mật khẩu mới của bạn !';
			} elseif ($data[ 'new_password' ] !== $data[ 'confirm_password' ]) {
				$errors[ 'confirm_password' ] = 'Mật khẩu nhập lại không khớp';
			}
			if (empty($errors)) {
				$result = $this->user->changePassword(password_hash($data[ 'new_password' ], PASSWORD_DEFAULT), $id);
				if ($result) {
					unset($_SESSION[ 'valid_data' ]);
					redirect('success', 'Đổi mật khẩu thành công', 'update-account/' . $id);
				}
			} else {
				redirect('errors', $errors, 'change-password/' . $id);
			}
			
		}
		
		
		
	}