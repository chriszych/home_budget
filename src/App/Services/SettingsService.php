<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Framework\Database;
use Framework\Exceptions\ValidationException;
//use App\Controllers\SettingsController;



class SettingsService 
{

    public function __construct(
        private Database $db)
        //private SettingsController $settingsController)
    {

    }

    public function listUserIncomeCategories(int $userId)
    //public function getUserIncomeCategory(string $id_category)
    {
        return $this->db->query(
            "SELECT id_inc_user_cat, inc_cat_name 
            FROM income_user_category
            WHERE id_user = :id_user 
            ORDER BY inc_cat_name",
            //AND id_inc_user_cat = :id_cat",
            [
                'id_user' => $userId,
                //'id_cat' => $id_category
            ]
        )->findAll();
    }

    public function listUserExpenseCategories(int $userId)
    //public function getUserExpenseCategory(string $id_category)
    {
        return $this->db->query(
            "SELECT id_exp_user_cat, exp_cat_name 
            FROM expense_user_category
            WHERE id_user = :id_user
            ORDER BY exp_cat_name", 
            //AND id_exp_user_cat = :id_cat",
            [
                'id_user' => $userId
                //'id_user' => $_SESSION['user'],
                //'id_cat' => $id_category
            ]
        )->findAll();
    }

    public function listUserPaymentMethods(int $userId)
    //public function getUserPaymentMethod(string $id_category)
    {
        return $this->db->query(
            "SELECT id_user_pay_met, pay_met_name 
            FROM payment_user_method
            WHERE id_user = :id_user
            ORDER BY pay_met_name", 
            //AND id_user_pay_met = :id_cat",
            [
                'id_user' => $userId
                //'id_user' => $_SESSION['user'],
                //'id_cat' => $id_category
            ]
        )->findAll();
    }

    // private function isCategoryNameTaken(int $userId, array $params)
    // {
    //     $categoryName = $params['formData'][$params['formKey']];
    //     $sqlParams = [
    //         'id_user'   => $userId, 
    //         'category'  => $categoryName
    //         ];

    //     $table = $params['table'];
    //     $nameColumn = $params['nameColumn'];
    //     $categoryId = $params['categoryId'];
    //     $idColumn = $params['idColumn'];
        
    //     $query = "SELECT COUNT(*) FROM {$table} 
    //     WHERE id_user = :id_user 
    //     AND {$nameColumn} = :category";


    //     if ($categoryId > 0) {
    //         $query .= " AND {$idColumn} != :id_cat";
    //         $sqlParams['id_cat'] = $categoryId;
    //     }

    //     $count = $this->db->query($query, $sqlParams)->count();

    //     if ($count > 0) {
    //         throw new ValidationException([$params['formKey'] => ['This category already exists!']]);
    //     }
    // }    

    // public function isIncomeCategoryTaken(array $formData, int $userId, int $categoryId = 0)
    // {
    // $params = [
    //     'table'         => 'income_user_category',
    //     'nameColumn'    => 'inc_cat_name',
    //     'formKey'       => 'incomeCategory',
    //     'idColumn'      => 'id_inc_user_cat',
    //     'formData'      => $formData,
    //     'categoryId'    => $categoryId
    // ];

    // $this->isCategoryNameTaken($userId, $params);
    // }

    // public function isExpenseCategoryTaken(array $formData, int $userId, int $categoryId = 0)
    // {
    // $params = [
    //     'table'         => 'expense_user_category',
    //     'nameColumn'    => 'exp_cat_name',
    //     'formKey'       => 'expenseCategory',
    //     'idColumn'      => 'id_exp_user_cat',
    //     'formData'      => $formData,
    //     'categoryId'    => $categoryId
    // ];

    // $this->isCategoryNameTaken($userId, $params);
    // }

    // public function isPaymentMethodTaken(array $formData, int $userId, int $categoryId = 0)
    // {
    // $params = [
    //     'table'         => 'payment_user_method',
    //     'nameColumn'    => 'pay_met_name',
    //     'formKey'       => 'paymentMethod',
    //     'idColumn'      => 'id_user_pay_met',
    //     'formData'      => $formData,
    //     'categoryId'    => $categoryId
    // ];

    // $this->isCategoryNameTaken($userId, $params);
    // }

    // public function isCategoryUsed(int $userId, array $params)
    // {
        
    //     $count = $this->db->query(
    //         "SELECT COUNT(*) FROM {$params['transactionTable']} 
    //         WHERE id_user = :id_user
    //         AND {$params['foreignKey']} = :id_cat",
    //         [
    //             'id_user' => $userId,
    //             'id_cat' => $params['categoryId']
    //         ]
    //     )->count();

    //     if ($count > 0) {
    //         throw new ValidationException(['usedCategory' => ['Kategoria jest używana, nie może być usunięta!']]);
    //     }
    // }

    // private function insertCategory(int $userId, array $params)
    // {

    //     $this->isCategoryNameTaken($userId, $params);
        
    //     $this->db->query(
    //         "INSERT INTO {$params['table']}(id_user, {$params['nameColumn']}) 
    //         VALUES (:id_user, :category)",
    //         [
    //             'id_user' => $userId,
    //             'category' => $params['formData'][$params['formKey']]
    //         ]
    //     );
    // }

    // private function updateCategory(int $userId, array $params)
    // {
    //     $this->isCategoryNameTaken($userId, $params);
        
    //     $this->db->query(
    //         "UPDATE {$params['table']}
    //         SET {$params['nameColumn']} = :new_category
    //         WHERE id_user = :id_user 
    //         AND {$params['idColumn']} = :id_cat",
    //         [
    //             'id_user' => $userId,
    //             'id_cat' => $params['categoryId'],
    //             'new_category' => $params['formData'][$params['formKey']]
    //         ]
    //     );
    // }

    // private function deleteCategory(int $userId, array $params)
    // {
    //     $this->db->query(
    //         "DELETE FROM {$params['table']} 
    //         WHERE id_user = :id_user 
    //         AND {$params['idColumn']} = :id_cat",
    //         [
    //             'id_user' => $userId,
    //             'id_cat' => $params['categoryId']
    //         ]
    //     );
    // }

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
    //income category CRUD
    // public function insertIncomeCategory(array $formData, int $userId)
    // {
    //     $metadata = [
    //         'table'         => 'income_user_category', 
    //         'nameColumn'    => 'inc_cat_name', 
    //         'formKey'       => 'incomeCategory', 
    //         'formData'      => $formData
    //     ];
    //     $this->insertCategory($userId, $metadata);
    // }

    // public function updateIncomeCategory(array $formData, int $categoryId, int $userId): void
    // {
    //     $metadata = [
    //         'table'         => 'income_user_category', 
    //         'nameColumn'    => 'inc_cat_name', 
    //         'formKey'       => 'incomeCategory', 
    //         'formData'      => $formData,
    //         'idColumn'      => 'id_inc_user_cat', 
    //         'categoryId'    => $categoryId
    //     ];
    //     $this->updateCategory($userId, $metadata);
    // }

    // public function deleteIncomeCategory(int $userId, int $categoryId)
    // {
    //     $metadata = [
    //         'table'         => 'income_user_category', 
    //         'idColumn'      => 'id_inc_user_cat', 
    //         'categoryId'    => $categoryId
    //     ];
    //     $this->deleteCategory($userId, $metadata);
    // }

    // public function isIncomeCategoryUsed(int $categoryId, int $userId)
    // {
    //     $metadata = [
    //         'transactionTable'  => 'income', 
    //         'foreignKey'        => 'id_inc_cat', 
    //         'categoryId'        => $categoryId
    //     ];
    //     $this->isCategoryUsed($userId, $metadata);
    // }
    // //expense category CRUD
    // public function insertExpenseCategory(array $formData, int $userId): void
    // {
    //     $metadata = [
    //         'table'         => 'expense_user_category', 
    //         'nameColumn'    => 'exp_cat_name', 
    //         'formKey'       => 'expenseCategory', 
    //         'formData'      => $formData
    //     ];
    //     $this->insertCategory($userId, $metadata);
    // }

    // public function updateExpenseCategory(array $formData, int $categoryId, int $userId)
    // {
    //     $metadata = [
    //         'table'         => 'expense_user_category', 
    //         'nameColumn'    => 'exp_cat_name', 
    //         'formKey'       => 'expenseCategory', 
    //         'formData'      => $formData,
    //         'idColumn'      => 'id_exp_user_cat', 
    //         'categoryId'    => $categoryId
    //     ];
    //     $this->updateCategory($userId, $metadata);
    // }

    // public function deleteExpenseCategory(int $userId, int $categoryId)
    // {
    //     $metadata = [
    //         'table'         => 'expense_user_category', 
    //         'idColumn'      => 'id_exp_user_cat', 
    //         'categoryId'    => $categoryId
    //     ];
    //     $this->deleteCategory($userId, $metadata);
    // }
    
    // public function isExpenseCategoryUsed(int $categoryId, int $userId)
    // {
    //     $metadata = [
    //         'transactionTable'  => 'expense', 
    //         'foreignKey'        => 'id_exp_cat', 
    //         'categoryId'        => $categoryId
    //     ];
    //     $this->isCategoryUsed($userId, $metadata);
    // }
    // //payment method CRUD
    // public function insertPaymentMethod(array $formData, int $userId): void
    // {
    //     $metadata = [
    //         'table'         => 'payment_user_method', 
    //         'nameColumn'    => 'pay_met_name', 
    //         'formKey'       => 'paymentMethod', 
    //         'formData'      => $formData
    //     ];
    //     $this->insertCategory($userId, $metadata);
    // }

    // public function updatePaymentMethod(array $formData, int $categoryId, int $userId)
    // {
    //     $metadata = [
    //         'table' => 'payment_user_method', 
    //         'nameColumn' => 'pay_met_name', 
    //         'formKey' => 'paymentMethod', 
    //         'formData' => $formData,
    //         'idColumn' => 'id_user_pay_met', 
    //         'categoryId' => $categoryId
    //     ];
    //     $this->updateCategory($userId, $metadata);
    // }

    // public function deletePaymentMethod(int $userId, int $categoryId)
    // {
    //     $metadata = [
    //         'table' => 'payment_user_method', 
    //         'idColumn' => 'id_user_pay_met', 
    //         'categoryId' => $categoryId
    //     ];
    //     $this->deleteCategory($userId, $metadata);
    // }

    // public function isPaymentMethodUsed(int $categoryId, int $userId)
    // {
    //     $metadata = [
    //         'transactionTable'  => 'expense', 
    //         'foreignKey'        => 'id_pay_met', 
    //         'categoryId'        => $categoryId
    //     ];
    //     $this->isCategoryUsed($userId, $metadata);
    // }

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

    // public function deleteCategoryGeneric(string $categoryId, string $tableName, string $idColumn): void
    // {
    // $this->db->query(
    //     "DELETE FROM {$tableName} 
    //     WHERE {$idColumn} = :id_cat", 
    //     [
    //         'id_cat' => $categoryId
    //     ]
    // );
    // }

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
        throw new ValidationException(['categoryName' => 'Category name already exists']);
    }
}

// public function isIncomeCategoryTaken(array $formData, int $userId, ?int $categoryId): void
// {
//     //$map = $this->SettingsController->getCategoryMap('income'); // Wymaga dostępu do mapowania!
//     //$this->isCategoryTakenGeneric($formData, $userId, $categoryId, $map);
// }

//other catheries?

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
        $txTable = $map['tx_table'];    // 'income' lub 'expense'
        $txFkCol = $map['tx_fk_col'];   // 'id_inc_cat' lub 'id_exp_cat' lub 'id_pay_met'
        $dbIdCol = $map['db_id_col'];   // 'id_inc_user_cat' lub 'id_exp_user_cat' lub 'id_user_pay_met'
        $dbTable = $map['db_table'];    // np. 'income_user_category'
        $nameCol = $map['db_name_col']; // np. 'inc_cat_name'
        $categoryType = $map['category_type'];
        
        // SELECT * z tabeli transakcji, gdzie klucz obcy pasuje do ID kategorii
        $query = "SELECT {$nameCol} 
                  FROM {$dbTable}
                  JOIN {$txTable}
                  ON {$dbIdCol} = {$txFkCol}
                  WHERE {$dbIdCol} = :id_cat";
        
        $count = $this->db->query($query, ['id_cat' => $categoryId])->count();
        
        if ($count > 0) {
            throw new ValidationException(
                ['usedCategory' => "Can't delete - this category is used."],
                //['id_cat' => $categoryId] // Wracamy z błędem walidacji na listę
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