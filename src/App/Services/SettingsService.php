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

    public function isCategoryTaken(string $category)
    {
        $incomeCategoryCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM income_user_category 
            WHERE id_user = :id_user 
            AND inc_cat_name = :category",
            [
                'id_user' => $_SESSION['user'],
                'category' => $category
            ]
        )->count();

        if ($incomeCategoryCount > 0)
        
        {
            throw new ValidationException(['newIncomeCategory' => ['Kategoria jest już dodana!']]);
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
                'category' => $formData['newIncomeCategory']
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

    public function editIncomeCategory()
    {
        
    }


}   
