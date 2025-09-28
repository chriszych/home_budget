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
        // echo $this->view->render("transactions/editIncomeCategory.php");
        $params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

        echo $this->view->render("transactions/listIncomeCategory.php", $params);
    }

    public function addIncomeView()
    {   
        //$params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

        echo $this->view->render("transactions/addIncomeCategory.php");
    }

    public function addIncomeCategory() 
    {
        $this->validatorService->validateIncomeCategory($_POST);
        $this->settingsService->isCategoryTaken($_POST['newIncomeCategory']);
        $this->settingsService->insertIncomeCategory($_POST);

        redirectTo('/listIncomeCategory');
    }
}
