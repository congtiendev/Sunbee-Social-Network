<?php

use JetBrains\PhpStorm\NoReturn;

const DBNAME = "sunbee-social-network";
const DBUSER = "root";
const DBPASS = "";
const DBCHARSET = "utf8";
const DBHOST = "127.0.0.1";
const BASE_URL = "http://localhost:88/Sunbee-Social-Network/";
const IMG_PATH = BASE_URL . "public/images/";
const AVATAR_PATH = BASE_URL . "public/uploads/avatars/";
const COVER_PATH = BASE_URL . "public/uploads/covers/";
const POST_MEDIA_PATH = BASE_URL . "public/uploads/posts/";
const COMMENT_MEDIA_PATH = BASE_URL . "public/uploads/comments/";
date_default_timezone_set('Asia/Ho_Chi_Minh');

function route($name): string
{
	return BASE_URL . $name;
}

function isImage($image)
{
	$extension = pathinfo($image, PATHINFO_EXTENSION);
	$extension = strtolower($extension);
	$images = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
	if (in_array($extension, $images)) {
		return true;
	}
	return false;
}

function redirect($key, $msg, $route)
{
	$_SESSION[$key] = $msg;
	switch ($key) {
		case 'success':
			unset($_SESSION['errors']);
			unset($_SESSION['old']);
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


function timeAgo($timestamp)
{
	$timestamp = strtotime($timestamp);
	$current_time = time();
	$diff = $current_time - $timestamp;

	$minute = 60;
	$hour = 60 * $minute;
	$day = 24 * $hour;
	$week = 7 * $day;
	$month = 30 * $day;

	if ($diff < $minute) {
		$time_ago = 'Vừa xong';
	} elseif ($diff < $hour) {
		$time_ago = floor($diff / $minute) . ' phút trước';
	} elseif ($diff < $day) {
		$time_ago = floor($diff / $hour) . ' giờ trước';
	} elseif ($diff < $week) {
		$time_ago = floor($diff / $day) . ' ngày trước';
	} elseif ($diff < $month) {
		$time_ago = floor($diff / $week) . ' tuần trước';
	} else {
		$time_ago = floor($diff / $month) . ' tháng trước';
	}

	return $time_ago;
}
