<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Controllers\RequestController;
use App\Validation\Validator;


class AuthController extends BaseController
{
    private $auth;
    private $request;
    private $validator;


    public function __construct()
    {
        $this->auth = new Auth();
        $this->request = new RequestController();
        $this->validator = new Validator($this->request->all());
    }
    public function isLoggedIn()
    {
        return isset($_SESSION['auth']) && !empty($_SESSION['auth']);
    }
    public function isRemembered()
    {
        if (isset($_COOKIE['account']) && !empty($_COOKIE['account']) && isset($_COOKIE['password']) && !empty($_COOKIE['password'])) {
            $account = $_COOKIE['account'];
            $password = $_COOKIE['password'];
            $user = $this->auth->login([
                'account' => $account,
                'password' => $password,
            ]);
            if ($user) {
                $_SESSION['auth'] = $user;
                return true;
            }
        }
    }
    public function renderLogin()
    {
        $title = "Đăng nhập 🐝 Sunbee";
        if ($this->isLoggedIn() || $this->isRemembered()) {
            $message = "Bạn đã đăng nhập";
            return redirect('', $message, 'back');
        } else {
            $this->render('auth.login', compact('title'));
        }
    }

    public function renderRegister()
    {
        $title = "Đăng ký 🐝 Sunbee";
        if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
            $message = "Vui lòng đăng xuất để đăng ký tài khoản mới";
            return redirect('errors', $message, 'back');
        } else {
            $this->render('auth.register', compact('title'));
        }
    }

    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
        }
        $data = $this->request->all();
        $password = '';
        if (!empty($data['account'])) {
            $password = $this->auth->getAccount($data['account'])->password;
        }

        $rules = [
            'account' => 'required',
            'password' => 'required|password:' . $password,
        ];
        $messages = [
            'account.required' => "Vui lòng nhập email, số điện thoại hoặc tên người dùng",
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.password' => "Tên người dùng hoặc mật khẩu không chính xác",
        ];
        $errors = [];
        $this->validator->setRules($rules);
        $this->validator->setMessages($messages);
        $this->validator->Validation();
        $errors = $this->validator->getErrors();
        if (empty($errors)) {
            $data['password'] = $password;
            $user = $this->auth->login($data);
            if ($user) {
                $_SESSION['auth'] = $user;
                if ($data['remember'] === 'on') {
                    setcookie('account', $data['account'], time() + (86400 * 30), '/');
                    setcookie('password', $data['password'], time() + (86400 * 30), '/');
                } else {
                    setcookie('account', '', time() - (86400 * 30), '/');
                    setcookie('password', '', time() - (86400 * 30), '/');
                }
                return redirect('success', 'Đăng nhập thành công', '');
            }
            echo "Đăng nhập thất bại";
        } else {
            return redirect('errors', $errors, 'login');
        }
    }

    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return redirect('errors', 'Không thể thực hiện thao tác này', 'back');
        }
        $data = $this->request->all();
        $password = $this->request->get('password');
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $errors = [];
        $rules = [
            'first_name' => 'required|alpha_unicode|min:2|max:50',
            'last_name' => 'required|alpha_unicode|min:2|max:50',
            'username' => 'required|alpha_dash|min:2|max:50|unique:users,username',
            'email' => 'required|email|min:5|max:50|unique:users,email',
            'password' => 'required|min:6|max:50',
            'confirm_password' => 'required|confirmed:' . $password,
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

            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 50 ký tự',

            'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm_password.confirmed' => 'Mật khẩu nhập lại không khớp',
        ];
        $this->validator->setRules($rules);
        $this->validator->setMessages($messages);
        $this->validator->Validation();
        $errors = $this->validator->getErrors();

        if (empty($errors)) {
            $user = $this->auth->register($data);
            if ($user) {
                return redirect('success', 'Đăng ký thành công', 'login');
            }
        } else {
            return redirect('errors', $errors, 'register');
        }
    }
    public function logout()
    {
        unset($_SESSION['auth']);
        setcookie('account', '', time() - (86400 * 30), '/');
        setcookie('password', '', time() - (86400 * 30), '/');
        return redirect('', 'Đăng xuất thành công', '');
    }
}
