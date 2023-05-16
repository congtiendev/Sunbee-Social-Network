<?php
	/*
	 * Kiểm tra xem một chuỗi chỉ chứa các ký tự chữ cái không dấu
	 */
	
	namespace App\Validation\Rules;
	
	class AlphaValidator
	{
		public function passes($fieldValue): bool
		{
			return preg_match('/^[a-zA-Z]+$/', $fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must contain only alphabetic characters';
		}
	}
