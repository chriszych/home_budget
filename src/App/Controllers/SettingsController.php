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
        $this->settingsService->isCategoryTaken($_POST['newIncomeCategory']);
        $this->settingsService->insertIncomeCategory($_POST);

        redirectTo('/listIncomeCategory');
    }

    public function deleteIncomeCategory()
    {
        $this->settingsService->isCategoryUsed((int)$_POST['id_cat']);
        $this->settingsService->deleteIncomeCategory($_POST);
    }

    public function editIncomeView()
    {   
        //$params = $_POST;
        //dd($params);
        //echo $this->view->render("transactions/editIncomeCategory.php", $params);
        //echo $this->view->render("transactions/editIncomeCategory.php");
        echo $this->view->render("transactions/editIncomeCategory.php");
    }

    // public function updateIncomeCategory()
    // {
    //      $params = $_POST;
    //      dd($params);

    // }
        // $this->settingsService->isCategoryUsed((int)$_POST['id_cat']);
        // $this->settingsService->editIncomeCategory($_POST);
        
        //redirectTo('/listIncomeCategory');
public function updateIncomeCategory()
{
    var_dump($_POST);
}

    

}
