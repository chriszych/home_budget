<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
   public $now;
   public $nextYear;
   
    public function __construct(private Database $db)
    {
        $this -> now = date('Y-m-d\TH:i');
		$this -> nextYear = date('Y-m-d\TH:i', strtotime('+1 year'));
    }

   
    public function getUserExpensePayment(int $id) : array
    {
        $userExpenseCategories =  $this->db->query(
            "SELECT id_exp_user_cat, exp_cat_name 
            FROM expense_user_category 
            WHERE id_user = :user",
            [
                'user' => $id
            ])->findAll();

        $userPaymentMethods = $this->db->query(
            "SELECT id_user_pay_met, pay_met_name 
            FROM payment_user_method 
            WHERE id_user = :user",
            [
                'user' => $id
            ])->findAll();

        return [
            'expenseCategories' => $userExpenseCategories, 
            'paymentsMethods' => $userPaymentMethods,
            'now' => $this -> now,
            'nextYear'=> $this -> nextYear 
            ];
    }

    public function insertExpense(array $formData)
    {
        $formattedDate = "{$formData['date']}:00";

        $this->db->query(
            "INSERT INTO expense(id_user, exp_date, id_exp_cat, exp_amount, id_pay_met, exp_comment)
            VALUES(:user_id, :datetime, :categoryId, :amount, :paymentMethod, :comment)",
            [
                'user_id' => $_SESSION['user'],
                'datetime' => $formattedDate,
                'categoryId' => $formData['category'],
                'amount' => $formData['amount'],
                'paymentMethod' => $formData['paymentMethod'],
                'comment' => $formData['comment']
            ]
        );
    }

    public function getUserIncomeCategory(int $id) : array
    {
        $userIncomeCategories =  $this->db->query(
            "SELECT id_inc_user_cat, inc_cat_name 
            FROM income_user_category 
            WHERE id_user = :user",
            [
                'user' => $id
            ])->findAll();
        
        $count = count(array_column($userIncomeCategories, 'inc_cat_name'));

        return [
            'incomeCategories' => $userIncomeCategories,
            'now' => $this -> now,
            'nextYear'=> $this -> nextYear,
            'incomeCategoryCount' => $count
            ];
    }

    public function insertIncome(array $formData)
    {
        $formattedDate = "{$formData['date']}:00";

        $this->db->query(
            "INSERT INTO income(id_user, inc_date, id_inc_cat, inc_amount, inc_comment)
            VALUES(:user_id, :datetime, :categoryId, :amount, :comment)",
            [
                'user_id' => $_SESSION['user'],
                'datetime' => $formattedDate,
                'categoryId' => $formData['category'],
                'amount' => $formData['amount'],
                'comment' => $formData['comment']
            ]
        );
    }
}