<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Framework\Database;
use Framework\Exceptions\ValidationException;



class SettingsService 
{

    public function __construct(private Database $db)
    {

    }

    public function isIncomeCategoryTaken(array $params)
    {
        $query =
            "SELECT COUNT(*) 
            FROM income_user_category 
            WHERE id_user = :id_user 
            AND inc_cat_name = :category";
        
        $newParams = [
                'id_user' => $_SESSION['user'],
                'category' => $params['incomeCategory']
        ];

        if (!empty($params['id_cat'])) 
        {
            $query .= " AND id_inc_user_cat != :id_cat";
            $newParams['id_cat'] = $params['id_cat'];
        }


        $incomeCategoryCount = $this->db->query($query, $newParams)->count();

        if ($incomeCategoryCount > 0)
        
        {
            throw new ValidationException(['incomeCategory' => ['Kategoria jest już dodana!']]);
        }
    }

    public function isIncomeCategoryUsed(int $id_cat)
    {
        $incomeCategoryCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM income
            WHERE id_user = :id_user 
            AND id_inc_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat
            ]
        )->count();

        if ($incomeCategoryCount > 0)
        
        {
            throw new ValidationException(['usedCategory' => ['Kategoria jest używana, nie może być usunięta!']]);
        }
    }

    public function insertIncomeCategory(array $formData) 
    {
            $this->db->query(

            "INSERT INTO income_user_category(id_user, inc_cat_name) 
            VALUES (:id_user, :category)",
            [
                'id_user' => $_SESSION['user'],
                'category' => $formData['incomeCategory']
            ]
        );
    }

    public function deleteIncomeCategory(array $formData)
    {
        $this->db->query(
            "DELETE FROM income_user_category
            WHERE id_user = :id_user AND id_inc_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $formData['id_cat']
            ]
        );
        redirectTo('/listIncomeCategory');

    }

    public function getUserIncomeCategory(string $id_category)
    {
        return $this->db->query(
            "SELECT inc_cat_name FROM income_user_category
            WHERE id_user = :id_user AND id_inc_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_category
            ]
        )->find();
    }

    public function updateIncomeCategory(array $formData, int $id_cat)
    {

        $this->db->query(
            "UPDATE income_user_category
            SET inc_cat_name = :new_category
            WHERE id_user = :id_user AND id_inc_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat,
                'new_category' => $formData['incomeCategory']
            ]
            
        );
    }

    public function insertExpenseCategory(array $formData) 
    {
            $this->db->query(

            "INSERT INTO expense_user_category(id_user, exp_cat_name) 
            VALUES (:id_user, :category)",
            [
                'id_user' => $_SESSION['user'],
                'category' => $formData['expenseCategory']
            ]
        );
    }

    public function isExpenseCategoryTaken(array $params)
    {
        $query =
            "SELECT COUNT(*) 
            FROM expense_user_category 
            WHERE id_user = :id_user 
            AND exp_cat_name = :category";
        
        $newParams = [
                'id_user' => $_SESSION['user'],
                'category' => $params['expenseCategory']
        ];

        if (!empty($params['id_cat'])) 
        {
            $query .= " AND id_exp_user_cat != :id_cat";
            $newParams['id_cat'] = $params['id_cat'];
        }


        $expenseCategoryCount = $this->db->query($query, $newParams)->count();

        if ($expenseCategoryCount > 0)
        
        {
            throw new ValidationException(['expenseCategory' => ['Kategoria jest już dodana!']]);
        }
    }

    public function isExpenseCategoryUsed(int $id_cat)
    {
        $expenseCategoryCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM expense
            WHERE id_user = :id_user 
            AND id_exp_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat
            ]
        )->count();

        if ($expenseCategoryCount > 0)
        
        {
            throw new ValidationException(['usedCategory' => ['Kategoria jest używana, nie może być usunięta!']]);
        }
    }
    
    public function deleteExpenseCategory(array $formData)
    {
        $this->db->query(
            "DELETE FROM expense_user_category
            WHERE id_user = :id_user AND id_exp_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $formData['id_cat']
            ]
        );
        redirectTo('/listExpenseCategory');

    }

    public function getUserExpenseCategory(string $id_category)
    {
        return $this->db->query(
            "SELECT exp_cat_name FROM expense_user_category
            WHERE id_user = :id_user AND id_exp_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_category
            ]
        )->find();
    }

    public function updateExpenseCategory(array $formData, int $id_cat)
    {

        $this->db->query(
            "UPDATE expense_user_category
            SET exp_cat_name = :new_category
            WHERE id_user = :id_user AND id_exp_user_cat = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat,
                'new_category' => $formData['expenseCategory']
            ]
            
        );
    }

    public function getUserPaymentMethod(string $id_category)
    {
        return $this->db->query(
            "SELECT pay_met_name FROM payment_user_method
            WHERE id_user = :id_user AND id_user_pay_met = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_category
            ]
        )->find();
    }

    public function isPaymentMethodUsed(int $id_cat)
    {
        $paymentMethodCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM expense
            WHERE id_user = :id_user 
            AND id_pay_met = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat
            ]
        )->count();

        if ($paymentMethodCount > 0)
        
        {
            throw new ValidationException(['usedCategory' => ['Kategoria jest używana, nie może być usunięta!']]);
        }
    }

    public function isPaymentMethodTaken(array $params)
    {
        $query =
            "SELECT COUNT(*) 
            FROM payment_user_method 
            WHERE id_user = :id_user 
            AND pay_met_name = :category";
        
        $newParams = [
                'id_user' => $_SESSION['user'],
                'category' => $params['paymentMethod']
        ];

        if (!empty($params['id_cat'])) 
        {
            $query .= " AND id_user_pay_met != :id_cat";
            $newParams['id_cat'] = $params['id_cat'];
        }


        $paymentMethodCount = $this->db->query($query, $newParams)->count();

        if ($paymentMethodCount > 0)
        
        {
            throw new ValidationException(['paymentMethod' => ['Kategoria jest już dodana!']]);
        }
    }

    public function updatePaymentMethod(array $formData, int $id_cat)
    {

        $this->db->query(
            "UPDATE payment_user_method
            SET pay_met_name = :new_category
            WHERE id_user = :id_user AND id_user_pay_met = :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'id_cat' => $id_cat,
                'new_category' => $formData['paymentMethod']
            ]
            
        );
    }

    public function insertPaymentMethod(array $formData) 
    {
            $this->db->query(

            "INSERT INTO payment_user_method(id_user, pay_met_name) 
            VALUES (:id_user, :category)",
            [
                'id_user' => $_SESSION['user'],
                'category' => $formData['paymentMethod']
            ]
        );
    }

}   
