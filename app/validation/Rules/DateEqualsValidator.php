<?php
	/*
	 * Kiểm tra xem giá trị của một trường có phải là một ngày bằng với ngày được chỉ định hay không.
	 */
	
	namespace App\validation\Rules;
	
	class DateEqualsValidator
	{
		private $date;
		
		public function __construct(string $date)
		{
			$this->date = $date;
		}
		
		public function passes($fieldValue): bool
		{
			$fieldDate = \DateTime::createFromFormat('Y-m-d', $fieldValue);
			$comparisonDate = \DateTime::createFromFormat('Y-m-d', $this->date);
			
			if ($fieldDate && $comparisonDate) {
				return $fieldDate == $comparisonDate;
			}
			
			return false;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must be a date equals to ' . $this->date;
		}
		
	}