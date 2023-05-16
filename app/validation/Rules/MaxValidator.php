<?php
	
	namespace App\Validation\Rules;
	class MaxValidator
	{
		private $max;
		
		public function __construct(string $max)
		{
			$this->max = $max;
		}
		
		public function passes($fieldValue): bool
		{
			if (is_string($fieldValue)) {
				return strlen($fieldValue) <= $this->max;
			}
			return $fieldValue[ 'size' ] <= $this->convertToBytes($this->max);
		}
		
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			return $fieldName . ' must be at most ' . $this->max . ' bytes';
		}
		
		private function convertToBytes($size)
		{
			$unit = strtoupper(substr($size, -2));
			$value = substr($size, 0, -2);
			switch ($unit) {
				case 'KB':
					return $value * 1024;
				case 'MB':
					return $value * 1048576;
				case 'GB':
					return $value * 1073741824;
				default:
					return $size;
			}
		}
		
	}
