<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Framework\Database;
use Framework\Exceptions\ValidationException;


class SettingsService 
{

    public function __construct(
        private Database $db)
    {

    }

    public function listUserIncomeCategories(int $userId)
    {
        return $this->db->query(
            "SELECT id_inc_user_cat, inc_cat_name 
            FROM income_user_category
            WHERE id_user = :id_user 
            ORDER BY inc_cat_name",
            [
                'id_user' => $userId,
            ]
        )->findAll();
    }

    public function listUserExpenseCategories(int $userId)
    {
        return $this->db->query(
            "SELECT id_exp_user_cat, exp_cat_name 
            FROM expense_user_category
            WHERE id_user = :id_user
            ORDER BY exp_cat_name", 
            [
                'id_user' => $userId
            ]
        )->findAll();
    }

    public function listUserPaymentMethods(int $userId)
    {
        return $this->db->query(
            "SELECT id_user_pay_met, pay_met_name 
            FROM payment_user_method
            WHERE id_user = :id_user
            ORDER BY pay_met_name", 
            [
                'id_user' => $userId
            ]
        )->findAll();
    }

    public function getCategory(int $userId, array $params)
    {
        return $this->db->query(
            "SELECT {$params['nameColumn']} FROM {$params['table']} 
            WHERE id_user = :id_user 
            AND {$params['idColumn']} = :id_cat",
            [
                'id_user' => $userId,
                'id_cat' => $params['categoryId']
            ]
        )->find();
    }

    public function getUserData(int $userId)
    {
        return $this->db->query(
            "SELECT user_firstname, user_lastname, user_email FROM users 
            WHERE id_user = :id_user",
            [
                'id_user' => $userId
                ]
        )->find();
    }

    public function isEmailUsed(string $email, int $userId)
    {
        $count = $this->db->query(
            "SELECT COUNT(*) FROM users 
            WHERE user_email = :email 
            AND id_user != :id_user",
            [
                'email'     => $email, 
                'id_user'   => $userId
                ]
        )->count();

        if ($count > 0) {
            throw new ValidationException(['email' => ['Adres e-mail jest już zajęty!']]);
        }
    }

    public function updateUser(array $formData, int $userId)
    {
        $this->db->query(
            "UPDATE users
            SET user_firstname = :firstname, user_lastname = :lastname, user_email = :email
            WHERE id_user = :id_user",
            [
                'firstname' => $formData['firstname'],
                'lastname' => $formData['lastname'],
                'email' => $formData['email'],
                'id_user' => $userId
            ]
        );
    }

    public function updatePassword(array $formData, int $userId)
    {
        $password = password_hash($formData['password'], PASSWORD_DEFAULT);

        $this->db->query(
            "UPDATE users
            SET user_password = :password 
            WHERE id_user = :id_user",
            [
                'password'  => $password,
                'id_user'   => $userId
            ]
        );
    }

    public function deleteUserTransactions(int $userId)
    {
        $this->db->query(
            "DELETE FROM income 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
        
        $this->db->query(
            "DELETE FROM expense 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
    }

    public function deleteUserCategories(int $userId)
    {
        $this->db->query(
            "DELETE FROM payment_user_method 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
        
        $this->db->query(
            "DELETE FROM income_user_category 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
        
        $this->db->query(
            "DELETE FROM expense_user_category 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
    }

    public function deleteCurrentUser(int $userId)
    {
        $this->db->query(
            "DELETE FROM users 
            WHERE id_user = :id_user", 
            [
                'id_user'   => $userId
            ]);
    }


    public function isCategoryTakenGeneric(array $formData, int $userId, ?int $categoryId, array $map): void
    {
        $name = $formData['categoryName'];
        $dbTable = $map['db_table'];
        $nameCol = $map['db_name_col'];
        $idCol = $map['db_id_col'];

        $query = "SELECT COUNT(*) FROM {$dbTable} 
                  WHERE {$nameCol} = :name AND id_user = :id_user";
            $params = [
            'name' => $name,
            'id_user' => $userId
            ];

        if ($categoryId) {
            $query .= " AND {$idCol} != :id_cat";
            $params['id_cat'] = $categoryId;
        }

        $count = $this->db->query($query, $params)->count();

    if ($count > 0) {
        throw new ValidationException(['categoryName' => ['Category name already exists']]);
    }
}

public function insertCategoryGeneric(array $formData, int $userId, array $map): void
    {
        $name = $formData['categoryName'];
        $dbTable = $map['db_table'];
        $nameCol = $map['db_name_col'];

        $this->db->query(
            "INSERT INTO {$dbTable}(id_user, {$nameCol})
             VALUES(:id_user, :name)",
            [
                'id_user' => $userId,
                'name' => $name
            ]
        );
    }

    public function updateCategoryGeneric(array $formData, int $categoryId, array $map): void
    {
        $name = $formData['categoryName'];
        $dbTable = $map['db_table'];
        $nameCol = $map['db_name_col'];
        $idCol = $map['db_id_col'];

        $this->db->query(
            "UPDATE {$dbTable} 
             SET {$nameCol} = :name
             WHERE {$idCol} = :id_cat",
            [
                'name' => $name,
                'id_cat' => $categoryId
            ]
        );
    }

    public function isCategoryUsedGeneric(int $categoryId, array $map): void
    {
        $txTable = $map['tx_table'];
        $txFkCol = $map['tx_fk_col'];
        $dbIdCol = $map['db_id_col'];
        $dbTable = $map['db_table'];
        $nameCol = $map['db_name_col'];
        
        $query = "SELECT {$nameCol} 
                  FROM {$dbTable}
                  JOIN {$txTable}
                  ON {$dbIdCol} = {$txFkCol}
                  WHERE {$dbIdCol} = :id_cat";
        
        $count = $this->db->query($query, ['id_cat' => $categoryId])->count();

        if ($count > 0) {
            throw new ValidationException(
                ['usedCategory' => ["Can't delete - this category is used."]],
            );
        }
    }
    public function deleteCategoryGeneric(int $categoryId, array $map): void
    {
        $dbTable = $map['db_table'];
        $idCol = $map['db_id_col'];

        $this->db->query(
            "DELETE FROM {$dbTable} 
             WHERE {$idCol} = :id_cat",
            [
                'id_cat' => $categoryId
            ]
        );
    }

}