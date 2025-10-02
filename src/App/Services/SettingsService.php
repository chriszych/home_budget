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

    public function isCategoryTaken(array $params)
    {
        //dd($params);
        $incomeCategoryCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM income_user_category 
            WHERE id_user = :id_user 
            AND inc_cat_name = :category
            AND id_inc_user_cat != :id_cat",
            [
                'id_user' => $_SESSION['user'],
                'category' => $params['incomeCategory'],
                'id_cat' => $params['id_cat']
            ]
        )->count();

        if ($incomeCategoryCount > 0)
        
        {
            throw new ValidationException(['incomeCategory' => ['Kategoria jest już dodana!']]);
        }
    }

    public function isCategoryUsed(int $id_cat)
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
        // dd($formData);
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
        //dd($formData);
        //dd($id_cat);
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


}   
