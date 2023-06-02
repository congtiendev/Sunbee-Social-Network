<?php

namespace App\Validation\Rules;

class AcceptedValidator
{
	private $accepted;
	public function constructor($accepted)
	{
		$this->accepted = $accepted;
	}

	public function passes($fieldValue): bool
	{
		return $this->accepted;
	}

	public function message($fieldName, $message): string
	{
		if ($message) {
			return $message;
		}
		return $fieldName . ' must be accepted';
	}
}