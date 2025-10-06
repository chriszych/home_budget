<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{
    SettingsService, 
    TransactionService,
    ValidatorService
    };


class SettingsController
{
    
    public function __construct(
        private TemplateEngine $view,
        private SettingsService $settingsService,
        private ValidatorService $validatorService,
        private TransactionService $transactionService
        )
    {

    }    

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }

    public function listIncomeView()
    {   
        $params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

        echo $this->view->render("transactions/listIncomeCategory.php", $params);
    }

    public function addIncomeView()
    {   

        echo $this->view->render("transactions/addIncomeCategory.php");
    }

    public function addIncomeCategory() 
    {
        $this->validatorService->validateIncomeCategory($_POST);
        $this->settingsService->isIncomeCategoryTaken($_POST);
        $this->settingsService->insertIncomeCategory($_POST);

        redirectTo('/listIncomeCategory');
    }

    public function deleteIncomeCategory()
    {
        $this->settingsService->isIncomeCategoryUsed((int)$_POST['id_cat']);
        $this->settingsService->deleteIncomeCategory($_POST);
    }

    public function editIncomeView(array $id_cat)
    {   
        $params = $this->settingsService->getUserIncomeCategory($id_cat['category']);

        echo $this->view->render("transactions/editIncomeCategory.php", [
            'category' => $params['inc_cat_name'],
            'id_cat' => $id_cat['category']
        ]);
    }

    public function editIncomeCategory(array $category)
    {

        $this->validatorService->validateIncomeCategory($_POST);
        $this->settingsService->isIncomeCategoryTaken($_POST);
        $this->settingsService->updateIncomeCategory($_POST, (int)$category['category']);

        redirectTo('../listIncomeCategory');
    }

    public function addExpenseView()
    {   

        echo $this->view->render("transactions/addExpenseCategory.php");
    }

    public function addExpenseCategory() 
    {
        $this->validatorService->validateExpenseCategory($_POST);
        $this->settingsService->isExpenseCategoryTaken($_POST);
        $this->settingsService->insertExpenseCategory($_POST);

        redirectTo('/listExpenseCategory');
    }

    public function listExpenseView()
    {   
        $params = $this->transactionService->getUserExpenseCategory((int)$_SESSION['user']);  

        echo $this->view->render("transactions/listExpenseCategory.php", $params);
    }

    public function deleteExpenseCategory()
    {
        $this->settingsService->isExpenseCategoryUsed((int)$_POST['id_cat']);
        $this->settingsService->deleteExpenseCategory($_POST);
    }
    
    public function editExpenseView(array $id_cat)
    {   
        $params = $this->settingsService->getUserExpenseCategory($id_cat['category']);

        echo $this->view->render("transactions/editExpenseCategory.php", [
            'category' => $params['exp_cat_name'],
            'id_cat' => $id_cat['category']
        ]);
    }

    public function editExpenseCategory(array $category)
    {

        $this->validatorService->validateExpenseCategory($_POST);
        $this->settingsService->isExpenseCategoryTaken($_POST);
        $this->settingsService->updateExpenseCategory($_POST, (int)$category['category']);

        redirectTo('../listExpenseCategory');
    }

}
