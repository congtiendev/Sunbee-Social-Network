<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? '/' : $_GET['url'];
$route = new RouteCollector();

//Kiểm tra xem đã đăng nhập chưa
$route->filter('auth', function () {
	if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
		header('location: ' . route('sign-in'));
		die;
	}
});
$route->get('sign-in', [App\Controllers\UserController::class, 'SignIn']);
$route->post('store-sign-in', [App\Controllers\UserController::class, 'StoreSignIn']);
$route->group(['before' => 'auth'], function ($router) use ($route) {
	$route->get('/', [App\Controllers\UserController::class, 'index']);
	$route->get('list-user', [App\Controllers\UserController::class, 'index']);
	$route->get('create-user', [App\Controllers\UserController::class, 'CreateUser']);
	$route->post('store-create-user', [App\Controllers\UserController::class, 'StoreCreateUser']);
	$route->get('edit-user/{id}', [App\Controllers\UserController::class, 'EditUser']);
	$route->post('store-edit-user/{id}', [App\Controllers\UserController::class, 'StoreEditUser']);
	$route->get('delete-user/{id}', [App\Controllers\UserController::class, 'StoreDeleteUser']);
	$route->get('detail-user/{id}', [App\Controllers\UserController::class, 'DetailUser']);
	$route->get('list-notification', [App\Controllers\NotificationController::class, 'listNotification']);
	$route->get('delete-notification/{id}', [App\Controllers\NotificationController::class, 'StoreDeleteNotification']);
	$route->post('search-user', [App\Controllers\UserController::class, 'SearchUser']);
	$route->get('sign-up', [App\Controllers\UserController::class, 'SignUp']);
	$route->post('store-sign-up', [App\Controllers\UserController::class, 'StoreSignUp']);
	$route->get('sign-out', [App\Controllers\UserController::class, 'SignOut']);
	$route->get('list-post', [App\Controllers\PostController::class, 'index']);
	$route->get('accept-post/{id}', [App\Controllers\PostController::class, 'StorageAcceptPost']);
	$route->get('delete-post/{id}', [App\Controllers\PostController::class, 'StorageDeletePost']);
});
//Hiển thị thì dùng $route->get, thêm - sửa thì dùng $route->post

$dispatcher = new Phroute\Phroute\Dispatcher($route->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
echo $response;