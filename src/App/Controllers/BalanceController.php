<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{
    BalanceService,
    ValidatorService
};


class BalanceController
{

    public function __construct(
        private TemplateEngine $view,
        private BalanceService $balanceService,
        private ValidatorService $validatorService
        )
    {
        $_SESSION['vievMode'] = "CurrentMonth";
    }    

    public function balanceAllView()
    {   
        $_SESSION['vievMode'] = "CurrentMonth";

        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
                // 'viewMode' => $this->balanceViewMode
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance.php", $params);
    }
    public function balanceCategoryView()
    {   
        $params = array_merge(
            $this->balanceService->GetUserTransactionsByCategories(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
                // 'viewMode' => $this->balanceViewMode
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance2.php", $params);

    }

    public function customDatesView()
    {
        echo $this->view->render("./balance/customDates.php");
    }

    public function updateCustomDates()
    {
        $this->validatorService->validateBalanceDates($_POST);


            $params = array_merge(
            $this->balanceService->getUserTransactions($_POST),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
            ],
            $this->balanceService->checkBalancePage()
        );

        //test
        $_SESSION['vievMode'] = "customDates";
        //testEnd

        echo $this->view->render("balance.php", $params);
    }

    public function updateCurrentYear()
    {
        $dateParams = $this->balanceService->updateCurrentYear();
            
        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
            ],
            $this->balanceService->checkBalancePage()
        );

        //test
        $_SESSION['vievMode'] = "currentMonth";
        //testEnd

        echo $this->view->render("balance.php", $params);
    }

    public function updateLastMonth()
    {
        $dateParams = $this->balanceService->updateLastMonth();
            
        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
            ],
            $this->balanceService->checkBalancePage()
        );

        //test
        $_SESSION['vievMode'] = "lastMonth";
        //testEnd

        echo $this->view->render("balance.php", $params);
    }

    public function updateCurrentMonth()
    {
        $dateParams = $this->balanceService->updateCurrentMonth();
            
        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay
            ],
            $this->balanceService->checkBalancePage()
        );

        //test
        $_SESSION['vievMode'] = "currenMonth";
        //testEnd

        echo $this->view->render("balance.php", $params);
    }

    public function balanceView()
    {   
        $_SESSION['vievMode'] = "CurrentMonth";
        $uri = $_SERVER['REQUEST_URI'];

        if (str_starts_with($uri, '/balanceAll'))
        {
        $params = array_merge(
            $this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance.php", $params);
        }
        elseif (str_starts_with($uri, '/balanceCategory'))
        {

            $params = array_merge(
            $this->balanceService->GetUserTransactionsByCategories(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
                // 'viewMode' => $this->balanceViewMode
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance2.php", $params);

        }
    }
}
