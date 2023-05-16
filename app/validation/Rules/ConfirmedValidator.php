<?php
	
	namespace App\Validation\Rules;
	
	class ConfirmedValidator
	{
		private $confirmValue;
		
		public function __construct($confirmValue)
		{
			$this->confirmValue = $confirmValue;
		}
		
		public function passes($fieldValue): bool
		{
			if ($fieldValue === $this->confirmValue) {
				return true;
			}
			return false;
		}
		
		public function message($fieldName, $message)
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be confirmed';
		}
		
	}