<?php
	/*
	 * Kiểm tra xem một chuỗi chỉ chứa các ký tự chữ cái có hỗ trợ unicode
	 */
	
	namespace App\Validation\Rules;
	
	class AlphaUnicodeValidator
	{
		public function passes($fieldValue): bool
		{
			return preg_match('/^[\p{L}\s]+$/u', $fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must contain only alphabetic characters';
		}
	}
