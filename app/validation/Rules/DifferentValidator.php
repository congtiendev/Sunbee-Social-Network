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
