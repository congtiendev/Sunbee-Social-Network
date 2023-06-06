<?php

namespace App\Validation;

use App\Validation\Rules\RequiredValidator as RequiredValidator;
use App\Validation\Rules\MinValidator as MinValidator;
use App\Validation\Rules\BetweenValidator as BetweenValidator;
use App\Validation\Rules\MaxValidator as MaxValidator;
use App\Validation\Rules\StringValidator as StringValidator;
use App\Validation\Rules\NumericValidator as NumericValidator;
use App\Validation\Rules\AlphaValidator as AlphaValidator;
use App\Validation\Rules\AlphaUnicodeValidator as AlphaUnicodeValidator;
use App\Validation\Rules\AlphaNumValidator as AlphaNumValidator;
use App\Validation\Rules\AlphaDashValidator as AlphaDashValidator;
use App\Validation\Rules\UniqueValidator as UniqueValidator;
use App\Validation\Rules\ExistsValidator as ExistsValidator;
use App\Validation\Rules\DifferentValidator as DifferentValidator;
use App\Validation\Rules\ConfirmedValidator as ConfirmedValidator;
use App\Validation\Rules\EmailValidator as EmailValidator;
use App\Validation\Rules\PhoneValidator as PhoneValidator;
use App\Validation\Rules\FileValidator as FileValidator;
use App\Validation\Rules\MimesValidator as MimesValidator;
use App\Validation\Rules\InValidator as InValidator;
use App\Validation\Rules\DateValidator as DateValidator;
use App\Validation\Rules\DateEqualsValidator as DateEqualsValidator;
use App\Validation\Rules\BeforeValidator as BeforeValidator;
use App\Validation\Rules\AfterValidator as AfterValidator;
use App\Validation\Rules\BeforeOrEqualValidator as BeforeOrEqualValidator;
use App\Validation\Rules\AfterOrEqualValidator as AfterOrEqualValidator;
use App\Validation\Rules\ActiveUrlValidator as ActiveUrlValidator;
use App\Validation\Rules\PasswordValidator as PasswordValidator;
use App\Validation\Rules\AcceptedValidator as AcceptedValidator;


class Validator
{
	private array $data;
	private array $rules = [];
	private array $ruleClass = [
		'required' => RequiredValidator::class,
		'string' => StringValidator::class,
		'numeric' => NumericValidator::class,
		'alpha' => AlphaValidator::class,
		'alpha_unicode' => AlphaUnicodeValidator::class,
		'alpha_num' => AlphaNumValidator::class,
		'alpha_dash' => AlphaDashValidator::class,
		'min' => MinValidator::class,
		'between' => BetweenValidator::class,
		'max' => MaxValidator::class,
		'unique' => UniqueValidator::class,
		'exists' => ExistsValidator::class,
		'confirmed' => ConfirmedValidator::class,
		'email' => EmailValidator::class,
		'phone' => PhoneValidator::class,
		'file' => FileValidator::class,
		'mimes' => MimesValidator::class,
		'in' => InValidator::class,
		'different' => DifferentValidator::class,
		'date' => DateValidator::class,
		'date_equals' => DateEqualsValidator::class,
		'before' => BeforeValidator::class,
		'after' => AfterValidator::class,
		'before_or_equal' => BeforeOrEqualValidator::class,
		'after_or_equal' => AfterOrEqualValidator::class,
		'active_url' => ActiveUrlValidator::class,
		'password' => PasswordValidator::class,
		'accepted' => AcceptedValidator::class,
	];
	private array $errors = [];
	private array $messages = [];


	public function __construct(array $data)
	{
		$this->data = $data;
	}



	public function setRules(array $rules): void
	{
		$this->rules = $rules;
	}

	public function setMessages(array $messages): void
	{
		$this->messages = $messages;
	}

	public function Validation(): void
	{
		foreach ($this->rules as $fieldName => $rules) {
			$fieldValue = $this->data[$fieldName];

			if (!is_array($rules)) { // if rules is not array, convert it to array
				$rules = explode('|', $rules);
				// convert 'required|min:3|between:3,10' to ['required', 'min:3', 'between:3,10']
			}

			foreach ($rules as $rule) {

				$rule = explode(':', $rule); // convert 'min:3' to ['min', '3']
				$ruleName = $rule[0]; // get the first element of the array
				$ruleValue = explode(',', end($rule)); // convert '3,10' to ['3', '10'] (between:3,10)

				$className = $this->ruleClass[$ruleName];
				$validatorInstance = new $className(...$ruleValue);
				/* ...$ruleValue is the same as $ruleValue[0], $ruleValue[1], $ruleValue[2] */

				$isValidatorPasses = $validatorInstance->passes($fieldValue);
				if (!$isValidatorPasses) {
					$this->storagePassedData();
					$messages = $this->messages[$fieldName . '.' . $ruleName] ?? NULL;
					/* get the custom messages[$fieldName . '.' . $ruleName] = $messages['name.required'] */
					$this->errors[$fieldName][] = $validatorInstance->message($fieldName, $messages);
				}
			}
		}
		/*
																													 $fieldValue is the value from the form, $fieldName is the name of the field (e.g., name, email, password).
																													 $className is the name of the validation class (e.g., RequiredValidator::class).
																													 $validatorInstance is an instance of the validation class (e.g., new RequiredValidator()).
																													 $isValidationPassed is the result of the validation process (e.g., true, false).
																												 */
	}

	public function storagePassedData(): void
	{
		$_SESSION['old'] = $this->data;
	}
	public function getErrors(): array
	{
		return $this->errors;
	}
}