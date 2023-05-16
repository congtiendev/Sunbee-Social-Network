<?php
	
	namespace App\validation\Rules;
	
	class PhoneValidator
	{
		public function passes($fieldValue): bool
		{
			return preg_match('/^(?:\+?84|0)(?:\d{9}|\d{10})$/', $fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' is not a valid phone number';
		}
	}