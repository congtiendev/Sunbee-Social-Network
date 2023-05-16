<?php
	/*
	 *  Class này sẽ kiểm tra giá trị của một trường có nằm trong một mảng chỉ định hay không
	 */
	
	namespace App\Validation\Rules;
	
	class InValidator
	{
		private $in;
		
		public function __construct($in)
		{
			$this->in = $in;
		}
		
		public function passes($fieldValue): bool
		{
			return in_array($fieldValue, $this->in);
		}
		
		public function message($fieldName, $message)
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be in ' . implode(', ', $this->in);
		}
	}