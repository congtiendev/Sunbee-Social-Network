<?php
	
	namespace App\Validation\Rules;
	
	class DateValidator
	{
		private string $format;
		
		public function __construct(string $format)
		{
			$this->format = $format;
		}
		
		public function passes($value): bool
		{
			if (empty($value)) {
				return true;
			}
			$date = \DateTime::createFromFormat($this->format, $value);
			return $date && $date->format($this->format) === $value;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be a valid date in the format ' . $this->format;
		}
	}
