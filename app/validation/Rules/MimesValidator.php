<?php
/*
 * Class này được sử dụng để xác thực loại tệp dựa trên phần mở rộng (extension) của tệp. Nó kiểm tra xem tệp được
 *  tải lên có thuộc loại tệp cho phép hay không.
 */

namespace App\validation\Rules;

class MimesValidator
{
	private $allowedMimes;

	public function __construct($allowedMimes)
	{
		$this->allowedMimes = $allowedMimes;
	}

	public function passes($fieldValue): bool
	{
		if (empty($fieldValue['name'])) {
			return true;
		}
		$allowedMimes = explode('/', $this->allowedMimes);
		$extension = pathinfo($fieldValue['name'], PATHINFO_EXTENSION);
		return in_array($extension, $allowedMimes);
	}

	public function message($fieldName, $message): string
	{
		if ($message) {
			return $message;
		}
		return "$fieldName must be a valid file type";
	}
}