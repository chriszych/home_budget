<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Contracts\{RuleInterface};
use Framework\Rules\{
    RequiredRule, 
    EmailRule, 
    MinRule, 
    InRule, 
    UrlRule,
    MatchRule,
    LengthMaxRule,
    NumericRule,
    DateFormatRule,
    LaterDateRule
};

class ValidatorService 
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add('required', new RequiredRule());  
        $this->validator->add('email', new EmailRule());
        $this->validator->add('min', new MinRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('lengthMax', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateFormat', new DateFormatRule());
        $this->validator->add('laterDate', new LaterDateRule());
    }
    public function validateRegister(array $formData) 
    {

        $this->validator->validate($formData, [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'confirmPassword' => ['required', 'match:password'],
        ]);
    }

    public function validateLogin(array $formData) 
    {

        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    }

    public function validateTransaction(array $formData) 
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'lengthMax:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'dateFormat:Y-m-d']
        ]);
    }

    public function validateExpense(array $formData) 
    {
       
        $this->validator->validate($formData, [
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'dateFormat:Y-m-d\TG:i'],
            'category' => ['required'],
            'paymentMethod' => ['required'],
            'comment' => ['lengthMax:255']
        ]);
        
    }

    public function validateIncome(array $formData) 
    {
       
        $this->validator->validate($formData, [
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'dateFormat:Y-m-d\TG:i'],
            'category' => ['required'],
            'comment' => ['lengthMax:255']
        ]);
        
    }

    // public function validateIncomeCategory(array $formData) 
    // {
    //         $this->validator->validate($formData, [
    //         'incomeCategory' => ['required']
    //     ]);
    // }

    // public function validateExpenseCategory(array $formData) 
    // {
    //         $this->validator->validate($formData, [
    //         'expenseCategory' => ['required']
    //     ]);
    // }

    // public function validatePaymentMethod(array $formData) 
    // {
    //         $this->validator->validate($formData, [
    //         'paymentMethod' => ['required']
    //     ]);
    // }

    public function validateUserData(array $formData) 
    {

        $this->validator->validate($formData, [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email']
        ]);
    }

    public function validateUserPassword(array $formData) 
    {

        $this->validator->validate($formData, [
            'password' => ['required'],
            'confirmPassword' => ['required', 'match:password'],
        ]);
    }

    public function validateBalanceDates(array $formData) 
    {
        $this->validator->validate($formData, [
        'startDate' => ['required', 'dateFormat:Y-m-d\TG:i'],
        'endDate' => ['required', 'dateFormat:Y-m-d\TG:i', 'laterDate:startDate']
        ]);
    }

    public function validateCategoryName(array $formData): void
{
    // Sprawdza, czy klucz 'categoryName' istnieje w $_POST
    //$errors = 
    $this->validator->validate(
        $formData,
        [
            'categoryName' => ['required', 'min:3', 'max:50'] // Używamy ujednoliconej nazwy klucza
        ]
    );

    // if (count($errors)) {
    //     throw new ValidationException($errors, $formData);
    // }
}
}
