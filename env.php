<?php

use JetBrains\PhpStorm\NoReturn;

const DBNAME = "sunbee-social-network";
const DBUSER = "root";
const DBPASS = "";
const DBCHARSET = "utf8";
const DBHOST = "127.0.0.1";
const BASE_URL = "http://localhost:88/sunbee/";

function route($name): string
{
	return BASE_URL . $name;
}

function redirect($key, $msg, $route)
{
	$_SESSION[$key] = $msg;
	switch ($key) {
		case 'success':
			unset($_SESSION['errors']);
			break;
		case 'errors':
			unset($_SESSION['success']);
			break;
	}

	if ($key != "") {
		header('location:' . BASE_URL . $route . "?msg=" . $key);
	} else {
		header('location:' . BASE_URL . $route);
	}
	die;
}

function __redirect($key, $data, $msg, $route)
{
	$_SESSION[$key] = $msg;
	$_SESSION['valid_data'] = $data;
	switch ($key) {
		case 'success':
			unset($_SESSION['errors']);
			break;
		case 'errors':
			unset($_SESSION['success']);
			break;
	}

	if ($key != "") {
		header('location:' . BASE_URL . $route . "?data=" . $data . "?msg=" . $key);
	} else {
		header('location:' . BASE_URL . $route);
	}
	die;
}