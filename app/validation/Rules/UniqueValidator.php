<?php
	
	namespace App\Validation\Rules;
	
	use App\Models\BaseModel;
	
	class UniqueValidator
	{
		private $db;
		private $table;
		private $column;
		private $id;
		
		public function __construct($table, $column, $id = null)
		{
			$this->db = new BaseModel();
			$this->table = $table;
			$this->column = $column;
			$this->id = $id;
		}
		
		public function passes($fieldValue): bool
		{
			$data = $this->db->selectBy($this->table, $this->column, $this->id, $fieldValue);
			if ($data) {
				return false;
			}
			return true;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' is already exists';
		}
	}