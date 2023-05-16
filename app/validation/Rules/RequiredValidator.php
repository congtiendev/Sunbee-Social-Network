<?php
	
	namespace App\Validation\Rules;
	class RequiredValidator
	{
		
		public function passes($fieldValue): bool
		{
			return !empty($fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' is required';
		}
		
	}