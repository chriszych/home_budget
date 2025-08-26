<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(private Database $db)
    {
        
    }

    public function create(array $formData)
    {
        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            "INSERT INTO transactions(user_id, description, amount, date)
            VALUES(:user_id, :description, :amount, :date)",
            [
                'user_id' => $_SESSION['user'],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formattedDate
            ]
        );
    }

    public function getUserTransactions(int $length, int $offset)
    {
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');
        $params = [
                'user_id' => $_SESSION['user'],
                'description' => "%{$searchTerm}%"
            ];
        
        $transactions = $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions 
            WHERE user_id = :user_id
            AND description LIKE :description
            LIMIT {$length} OFFSET {$offset}",
            $params
        )->findAll();

        $transactions = array_map(function(array $transaction){
            $transaction['receipts'] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                ['transaction_id' => $transaction['id']]
            )->findAll();
            
            return $transaction;
        }, $transactions);

         $transactionCount = $this->db->query(
            "SELECT COUNT(*)
            FROM transactions 
            WHERE user_id = :user_id
            AND description LIKE :description",
            $params
         )->count();

        return [$transactions, $transactionCount];
    }

    public function getUserTransaction(string $id){
        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions 
            WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user']
            ]
        )->find();
    }

    public function update (array $formData, int $id) 
    {
        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            "UPDATE transactions
            SET description = :description,
            amount = :amount,
            date = :date
            WHERE id = :id
            AND user_id = :user_id", 
            [
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formattedDate,
                'id' => $id,
                'user_id' => $_SESSION['user']
            ]
        );
    }

    public function delete(int $id) 
    {
        $this->db->query(
            "DELETE FROM transactions WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user']
            ]
        );
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
            'paymentsMethods' => $userPaymentMethods
            ];
    }

    public function insertExpense(array $formData)
    {
        $formattedDate = "{$formData['date']} :00";

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


        return [
            'incomeCategories' => $userIncomeCategories, 
            ];
    }

    public function insertIncome(array $formData)
    {
        $formattedDate = "{$formData['date']} :00";

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