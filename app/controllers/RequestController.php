<?php

namespace App\controllers;

class RequestController
{
	private $data;

	public function __construct()
	{
		$this->data = array_merge($_GET, $_POST, $_FILES);
	}

	public function all()
	{
		return $this->data;
	}
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}
	public function get($key, $default = null)
	{
		return $this->input($key, $default);
	}

	public function post($key, $default = null)
	{
		return $this->input($key, $default);
	}

	public function input($key, $default = null)
	{
		$value = isset($this->data[$key]) ? $this->data[$key] : $default;
		return is_string($value) ? trim($value) : $value;
	}


	public function file($key)
	{
		return isset($_FILES[$key]) ? $_FILES[$key] : null;
	}

	public function has($key)
	{

		return isset($this->data[$key]);
	}

	/*	if ($request->has('email')) {
	Xử lý khi có giá trị email
	} else {
	Xử lý khi không có giá trị email
	}
	*/

	public function only(array $keys)
	{
		$data = [];
		foreach ($keys as $key) {
			if (isset($this->data[$key])) {
				$data[$key] = $this->data[$key];
			}
		}
		return $data;
	}

	/*
	$filteredData = $request->only(['name', 'email', 'phone']);
	$filteredData chỉ chứa các phần tử CÓ khóa là 'name', 'email', 'phone'
	*/

	public function except(array $keys)
	{
		$data = [];
		foreach ($this->data as $key => $value) {
			if (!in_array($key, $keys)) {
				$data[$key] = $value;
			}
		}
		return $data;
	}

	/*
	$filteredData = $request->except(['name', 'email', 'phone']);
	Ngươc lại với only, except sẽ loại bỏ các phần tử có khóa là 'name', 'email', 'phone'
	*/


	public function query($key, $default = null)
	{
		return $this->input($key, $default);
	}

/*
$page = $request->query('page', 1);
Lấy giá trị của 'page' từ $_GET hoặc trả về 1 nếu không có giá trị 'page'
*/


}