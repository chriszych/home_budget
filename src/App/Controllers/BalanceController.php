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
        $params1 = $this->balanceService->getUserTransactions();
        $params2 = $this->balanceService->getChartResults();
        $params3 = [
            'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
            'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
        ];
        $params4 = $this->balanceService->checkBalancePage();

        $params = array_merge($params1, $params2, $params3, $params4);

        echo $this->view->render("balance.php", $params);
    }
    public function balance2View()
    {   
        $params1 = $this->balanceService->GetUserTransactionsByCategories();
        $params2 = $this->balanceService->getChartResults();
        $params3 = [
            'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
            'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
        ];
        $params4 = $this->balanceService->checkBalancePage();

        $params = array_merge($params1, $params2, $params3, $params4);

        echo $this->view->render("balance2.php", $params);

    }
}
