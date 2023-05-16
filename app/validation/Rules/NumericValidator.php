<?php
	
	namespace App\Validation\Rules;
	
	class NumericValidator
	{
		public function passes($fieldValue): bool
		{
			return is_numeric($fieldValue);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must be a numeric value';
		}
	}
