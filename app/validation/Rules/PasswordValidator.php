<?php
	
	namespace App\Validation\Rules;
	
	class PasswordValidator
	{
		private $password;
		
		public function __construct($password)
		{
			$this->password = $password;
		}
		
		public function passes($fieldValue): bool
		{
			return password_verify($fieldValue, $this->password);
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' is incorrect';
		}
		
	}