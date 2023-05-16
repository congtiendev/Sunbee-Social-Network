<?php
	
	namespace App\Validation\Rules;
	
	class FileValidator
	{
		public function passes($fieldValue): bool
		{
			if (empty($fieldValue[ 'name' ])) {
				return false;
			}
			return true;
		}
		
		public function message($fieldName, $message): string
		{
			if (!empty($message)) {
				return $message;
			}
			return $fieldName . ' is invalid';
		}
	}
