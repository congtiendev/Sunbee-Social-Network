<?php
	
	namespace App\Validation\Rules;
	
	class EmailValidator
	{
		public function passes($fieldValue): bool
		{
			return filter_var($fieldValue, FILTER_VALIDATE_EMAIL);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' is not a valid email';
		}
	}