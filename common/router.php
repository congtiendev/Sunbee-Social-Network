<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$url = $_GET['url'] ?? '/';
$router = new RouteCollector();
$router->filter('auth', function () {
	if (!isset($_SESSION["auth"]) || empty($_SESSION["auth"])) {
		header('Location: ' . route('login'));
		die;
	}
});
$router->filter('admin', function () {
	if ($_SESSION["auth"]->role !== 1) {
		header('Location: ' . route('401'));
		die;
	}
});


$router->get('login', [App\Controllers\AuthController::class, 'renderLogin']);
$router->post('login/verify', [App\Controllers\AuthController::class, 'handleLogin']);
$router->get('logout', [App\Controllers\AuthController::class, 'logout']);
$router->get('register', [App\Controllers\AuthController::class, 'renderRegister']);
$router->post('register/handle', [App\Controllers\AuthController::class, 'handleRegister']);
$router->post('is-author', [App\Controllers\AuthController::class, 'isAuthor']);
$router->get('404', [App\Controllers\ErrorController::class, 'error404']);
$router->get('405', [App\Controllers\ErrorController::class, 'error405']);
$router->get('401', [App\Controllers\ErrorController::class, 'error401']);

$router->group(['before' => 'auth'], function () use ($router) {
	$router->get('/', [App\Controllers\Client\PostController::class, 'renderListPost']);
	$router->post('posts/create', [App\Controllers\Client\PostController::class, 'handleCreatePost']);
	$router->post('posts/like-post', [App\Controllers\Client\PostController::class, 'handleLikePost']);
	$router->post('posts/unlike-post', [App\Controllers\Client\PostController::class, 'handleUnlikePost']);
	$router->post('posts/save-post', [App\Controllers\Client\PostController::class, 'handleSavePost']);
	$router->post('posts/unsave-post', [App\Controllers\Client\PostController::class, 'handleUnSavePost']);
	$router->get('posts/delete/{post_id}', [App\Controllers\Client\PostController::class, 'handleDeletePost']);
	$router->post('posts/comment/add', [App\Controllers\Client\PostController::class, 'handleAddComment']);
	$router->post('posts/comment/like', [App\Controllers\Client\PostController::class, 'handleLikeComment']);
	$router->post('posts/comment/unlike', [App\Controllers\Client\PostController::class, 'handleUnlikeComment']);
	$router->post('posts/comment/is-liked', [App\Controllers\Client\PostController::class, 'isLikedComment']);
});


$router->group(
	['prefix' => 'admin'],
	function () use ($router) {
		$router->group(['before' => 'auth'], function () use ($router) {
			$router->group(['before' => 'admin'], function () use ($router) {
				// -------------------------------CRUD Account--------------------------------//
				$router->get('account/list', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
				$router->get('account/create', [App\Controllers\Admin\UserController::class, 'renderCreateAccount']);
				$router->get('account/update/{id}', [App\Controllers\Admin\UserController::class, 'renderUpdateAccount']);
				$router->post('account/create/handle', [App\Controllers\Admin\UserController::class, 'handleCreateAccount']);
				$router->post('account/update/handle/{id}', [App\Controllers\Admin\UserController::class, 'handleUpdateAccount']);
				$router->get('delete-account/{id}', [App\Controllers\Admin\UserController::class, 'deleteAccount']);

				// --------------------------------Profile-------------------------------------------//
				$router->get('profile/list', [App\Controllers\Admin\UserController::class, 'renderListProfile']);
				$router->get('profile/{id}', [App\Controllers\Admin\UserController::class, 'renderProfile']);
				$router->get('profile/update/{id}', [App\Controllers\Admin\UserController::class, 'renderUpdateProfile']);
				$router->post('profile/update/handle/{id}', [App\Controllers\Admin\UserController::class, 'handleUpdateProfile']);
				$router->post('change-avatar/{id}', [App\Controllers\Admin\UserController::class, 'handleChangeAvatar']);
				$router->get('delete-avatar/{id}', [App\Controllers\Admin\UserController::class, 'handleDeleteAvatar']);
				$router->post('change-cover-photo/{id}', [App\Controllers\Admin\UserController::class, 'handleChangeCoverPhoto']);
				$router->get('delete-cover-photo/{id}', [App\Controllers\Admin\UserController::class, 'handleDeleteCoverPhoto']);


				// -------------------------------Sort & Search User--------------------------------//
				$router->get('account/list/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
				$router->get('profile/list/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListProfile']);

				$router->get('search-user', [App\Controllers\Admin\UserController::class, 'searchUser']);
				$router->get('search-account/{keyword}/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
				$router->get('search-profile/{keyword}/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListProfile']);

				// --------------------------------Change password-------------------------------------------//
				$router->get('change-password/{id}', [App\Controllers\Admin\UserController::class, 'renderChangePassword']);
				$router->post('change-password/handle/{id}', [App\Controllers\Admin\UserController::class, 'handleChangePassword']);

				//--------------------------------------Post------------------------------------------------//
				$router->get('posts-manager', [App\Controllers\Admin\PostController::class, 'renderListPost']);
				$router->post('posts/create', [App\Controllers\Admin\PostController::class, 'handleCreatePost']);
				$router->post('posts/like-post', [App\Controllers\Admin\PostController::class, 'handleLikePost']);
				$router->post('posts/unlike-post', [App\Controllers\Admin\PostController::class, 'handleUnlikePost']);
				$router->post('posts/save-post', [App\Controllers\Admin\PostController::class, 'handleSavePost']);
				$router->post('posts/unsave-post', [App\Controllers\Admin\PostController::class, 'handleUnSavePost']);
				$router->get('posts/delete-post/{post_id}', [App\Controllers\Admin\PostController::class, 'handleDeletePost']);
				$router->post('posts/add-comment', [App\Controllers\Admin\PostController::class, 'handleAddComment']);
				$router->get('posts/delete-comment/{post_id}/{comment_id}', [App\Controllers\Admin\PostController::class, 'handleDeleteComment']);
				$router->get('posts/search-post', [App\Controllers\Admin\PostController::class, 'searchPost']);
				$router->get('posts-manager/{column}/{order}', [App\Controllers\Admin\PostController::class, 'renderListPost']);
				$router->get('search-post/{keyword}/{column}/{order}', [App\Controllers\Admin\PostController::class, 'renderListPost']);
			});
		});
	}
);



$router->get('back', function () {
	if (isset($_SERVER['HTTP_REFERER'])) {
		header("Location: " . $_SERVER['HTTP_REFERER']);
	} else {
		header("Location: /");
	}
});

$dispatcher = new Dispatcher($router->getData());

try {
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
	if ($response instanceof PDOStatement) {
		$data = $response->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
	} else {
		echo $response;
	}
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
	header("HTTP/1.0 404 Not Found");
	redirect('errors', 'Không tìm thấy trang', '404');
} catch (\Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
	header("HTTP/1.0 405 Method Not Allowed");
	redirect('errors', 'Phương thức không được cho phép', '405');
}
