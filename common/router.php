<?php

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$url = $_GET['url'] ?? '/';
$router = new RouteCollector();

$router->get('/', [App\Controllers\Admin\UserController::class, 'listAccounts']);
$router->get('list-accounts', [App\Controllers\Admin\UserController::class, 'listAccounts']);
$router->get('create-account', [App\Controllers\Admin\UserController::class, 'renderCreateAccount']);
$router->get('update-account/{id}', [App\Controllers\Admin\UserController::class, 'renderUpdateAccount']);
$router->post('save-create-account', [App\Controllers\Admin\UserController::class, 'handleCreateAccount']);
$router->post('save-update-account/{id}', [App\Controllers\Admin\UserController::class, 'handleUpdateAccount']);
$router->get('delete-account/{id}', [App\Controllers\Admin\UserController::class, 'deleteAccount']);

$dispatcher = new Dispatcher($router->getData());

try {
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
	echo $response;
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
	header("HTTP/1.0 404 Not Found");
	echo "Page not found!";
} catch (\Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
	header("HTTP/1.0 405 Method Not Allowed");
	echo "Method not allowed!";
}