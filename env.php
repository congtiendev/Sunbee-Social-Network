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
	#[NoReturn] function redirect($key, $msg, $route)
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
		header('location:' . BASE_URL . $route . "?msg=" . $key);
		die;
	}