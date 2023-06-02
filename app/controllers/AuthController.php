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
        if ($this->isLoggedIn()) {
            $message = "Bạn đã đăng nhập";
            return redirect('', $message, '');
        } else if ($this->isRemembered()) {
            $message = "Bạn đã đăng nhập";
            return redirect('', $message, '');
        } else {
            $title = "Đăng nhập 🐝 Sunbee";
            $this->render('auth.login', compact('title'));
        }
    }

    public function renderRegister()
    {
        if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
            $message = "Vui lòng đăng xuất để đăng ký tài khoản mới";
            return redirect('errors', $message, '');
        } else {
            $title = "Đăng ký 🐝 Sunbee";
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
        $_SESSION['valid_data'] = $data;
        if (empty($errors)) {
            unset($_SESSION['valid_data']);
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
        } else {
            return redirect('errors', $errors, 'login');
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