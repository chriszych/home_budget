<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{
    SettingsService, 
    TransactionService
    };


class SettingsController
{
    
    public function __construct(
        private TemplateEngine $view,
        private SettingsService $settingsService,
        private TransactionService $transactionService
        )
    {

    }    

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }

    public function editIncomeView()
    {   
        // echo $this->view->render("transactions/editIncomeCategory.php");
        $params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

        echo $this->view->render("transactions/editIncomeCategory.php", $params);
    }
}
