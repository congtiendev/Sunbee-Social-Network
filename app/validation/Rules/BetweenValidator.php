<?php
	
	namespace App\Validation\Rules;
	
	class BetweenValidator
	{
		private $min;
		private $max;
		
		public function __construct($min, $max)
		{
			$this->min = $min;
			$this->max = $max;
		}
		
		public function passes($fieldValue): bool
		{
			return strlen($fieldValue) >= $this->min && strlen($fieldValue) <= $this->max;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be between ' . $this->min . ' and ' . $this->max . ' characters';
		}
	}