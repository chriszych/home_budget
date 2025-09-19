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
        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance.php", $params);
    }
    public function balance2View()
    {   
        $params = array_merge(
            $this->balanceService->GetUserTransactionsByCategories(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance2.php", $params);

    }
}
