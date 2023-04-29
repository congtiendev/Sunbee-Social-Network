<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$url = $_GET['url'] ?? '/';
$router = new RouteCollector();
$router->get('404', [App\Controllers\ErrorController::class, 'render404']);
$router->get('/', [App\Controllers\Admin\UserController::class, 'renderListAccount']);

// -------------------------------CRUD Account--------------------------------//
$router->get('admin/list-account', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
$router->get('admin/create-account', [App\Controllers\Admin\UserController::class, 'renderCreateAccount']);
$router->get('admin/update-account/{id}', [App\Controllers\Admin\UserController::class, 'renderUpdateAccount']);
$router->post('admin/save-create-account', [App\Controllers\Admin\UserController::class, 'handleCreateAccount']);
$router->post('admin/save-update-account/{id}', [App\Controllers\Admin\UserController::class, 'handleUpdateAccount']);
$router->get('admin/delete-account/{id}', [App\Controllers\Admin\UserController::class, 'deleteAccount']);

// --------------------------------Profile-------------------------------------------//
$router->get('admin/detail-profile/{id}', [App\Controllers\Admin\UserController::class, 'renderDetailProfile']);
$router->get('admin/list-profile', [App\Controllers\Admin\UserController::class, 'renderListProfile']);
$router->get('admin/update-profile/{id}', [App\Controllers\Admin\UserController::class, 'renderUpdateProfile']);
$router->post('admin/save-update-profile/{id}', [App\Controllers\Admin\UserController::class, 'handleUpdateProfile']);
$router->post('admin/change-avatar/{id}', [App\Controllers\Admin\UserController::class, 'handleChangeAvatar']);
$router->post('admin/change-cover-photo/{id}', [App\Controllers\Admin\UserController::class, 'handleChangeCoverPhoto']);

// -------------------------------Sort & Search User--------------------------------//
$router->get('admin/list-account/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
$router->get('admin/list-profile/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListProfile']);

$router->get('admin/search-user', [App\Controllers\Admin\UserController::class, 'searchUser']);
$router->get('admin/search-account/{keyword}/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListAccount']);
$router->get('admin/search-profile/{keyword}/{column}/{order}', [App\Controllers\Admin\UserController::class, 'renderListProfile']);


// --------------------------------Change password-------------------------------------------//
$router->get('change-password/{id}', [App\Controllers\Admin\UserController::class, 'renderChangePassword']);
$router->post('save-change-password/{id}', [App\Controllers\Admin\UserController::class, 'handleChangePassword']);


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
	echo $response;
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
	redirect('errors', 'Không tìm thấy trang', '404');
} catch (\Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
	header("HTTP/1.0 405 Method Not Allowed");
	redirect('errors', 'Phương thức không được cho phép', '404');
}