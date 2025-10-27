<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
   
    public function __construct(private Database $db)
    {
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

    public function getFormDataForType(string $type, int $userId): array
    {
        if ($type === 'income') {

            $incomeCategories = $this->db->query(
                "SELECT id_inc_user_cat, inc_cat_name 
                FROM income_user_category 
                WHERE id_user = :user",
                ['user' => $userId]
            )->findAll();

            return ['incomeCategories' => $incomeCategories];
        
        } elseif ($type === 'expense') {

            $expenseCategories = $this->db->query(
                "SELECT id_exp_user_cat, exp_cat_name 
                FROM expense_user_category 
                WHERE id_user = :user",
                ['user' => $userId]
            )->findAll();
        
            $userPaymentMethods = $this->db->query(
                "SELECT id_user_pay_met, pay_met_name 
                FROM payment_user_method 
                WHERE id_user = :user",
                ['user' => $userId]
            )->findAll();

            return [
                'expenseCategories' => $expenseCategories, 
                'paymentMethods' => $userPaymentMethods,
            ];
        }
    
        throw new \InvalidArgumentException("Invalid transaction type provided: {$type}");
    }

}