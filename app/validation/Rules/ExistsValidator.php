<?php
/*
 * Class này sẽ  kiểm tra sự tồn tại của giá trị trong một bảng và cột chỉ định
 */

namespace App\validation\Rules;

use App\Models\BaseModel;

class ExistsValidator
{
	private $db;
	private $table;
	private $column;

	public function __construct($table, $column)
	{
		$this->db = new BaseModel();
		$this->table = $table;
		$this->column = $column;
	}

	public function passes($fieldValue): bool
	{
		return $this->db->selectBy($this->table, $this->column, NULL, $fieldValue);
	}

	public function message($fieldName, $message)
	{
		if ($message) {
			return $message;
		}
		return $fieldName . ' is not exists';
	}
}