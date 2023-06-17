<?php
	@session_start();
	require_once "env.php";
	require_once "vendor/autoload.php";
	require_once "common/router.php";
	$options = array(
		'cluster' => 'ap1',
		'useTLS' => true
	);
	
	$pusher = new Pusher\Pusher(
		'c3271ec62a7f5d395eb3',
		'ff3d133f0970c64aff62',
		'1618489',
		$options
	);
	
	$data[ 'message' ] = 'hello world';
	$pusher->trigger('my-channel', 'my-event', $data);