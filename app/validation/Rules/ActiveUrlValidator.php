<?php
	
	namespace App\Validation\Rules;
	
	class ActiveUrlValidator
	{
		public function passes($fieldValue): bool
		{
			return filter_var($fieldValue, FILTER_VALIDATE_URL) && checkdnsrr(parse_url($fieldValue, PHP_URL_HOST));
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must be a valid and active URL';
		}
	}
