<?php
	/*
	 * Kiểm tra xem một chuỗi chỉ chứa các ký tự chữ cái, số và dấu gạch ngang (-) và gạch dưới (_).
	 */
	
	namespace App\Validation\Rules;
	
	class AlphaDashValidator
	{
		public function passes($fieldValue): bool
		{
			return preg_match('/^[a-zA-Z0-9-_]+$/', $fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must contain only alphabetic characters, numbers, dashes, and underscores';
		}
	}