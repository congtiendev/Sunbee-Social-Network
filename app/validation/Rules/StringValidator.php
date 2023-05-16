<?php
	
	namespace App\Validation\Rules;
	
	class StringValidator
	{
		public function passes($fieldValue): bool
		{
			return is_string($fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be a string';
		}
		
	}