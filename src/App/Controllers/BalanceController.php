<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\BalanceService;


class BalanceController
{
    
    public function __construct(
        private TemplateEngine $view,
        private BalanceService $balanceService
        )
    {

    }    

    public function balanceView()
    {   
        $params = $this->balanceService->getUserTransactions();
        echo $this->view->render("balance.php", $params);
    }
}
