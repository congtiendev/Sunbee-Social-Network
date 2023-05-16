<?php
	/*
	 * Yêu cầu giá trị của trường phải là một ngày SAU ngày được chỉ định (date).
	 */
	
	namespace App\Validation\Rules;
	
	class AfterValidator
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
				return $fieldDate > $comparisonDate;
			}
			
			return false;
		}
		
		public function message($fieldName, $message): string
		{
			if ($message) {
				return $message;
			}
			
			return $fieldName . ' must be a date after ' . $this->date;
		}
	}