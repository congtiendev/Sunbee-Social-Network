<?php
	
	namespace App\Validation\Rules;
	
	class DifferentValidator
	{
		private $field;
		
		public function __construct(string $field)
		{
			$this->field = $field;
		}
		
		public function passes($fieldValue): bool
		{
			if (preg_match('/^\$2y\$/', $this->field)) {
				if (password_verify($fieldValue, $this->field)) {
					return false;
				}
				return true;
			}
			return $fieldValue !== $this->field;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must be different from ' . $this->field;
		}
		
	}
