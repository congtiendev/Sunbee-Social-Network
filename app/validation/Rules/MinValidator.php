<?php
	
	namespace App\Validation\Rules;
	
	class MinValidator
	{
		private $min;
		
		public function __construct(string $min)
		{
			$this->min = $min;
		}
		
		public function passes($fieldValue): bool
		{
			return strlen($fieldValue) >= $this->min;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be at least ' . $this->min . ' characters';
		}
	}