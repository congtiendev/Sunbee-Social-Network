<?php
	/*
	 * Kiểm tra xem một chuỗi chỉ chứa các ký tự chữ cái và số.
	 */
	
	namespace App\Validation\Rules;
	
	class AlphaNumValidator
	{
		public function passes($fieldValue): bool
		{
			return preg_match('/^[a-zA-Z0-9]+$/', $fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must contain only alphabetic characters and numbers';
		}
	}
