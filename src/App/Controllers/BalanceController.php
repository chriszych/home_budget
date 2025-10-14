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
       
       
        $_SESSION['vievMode'] = "currentMonth";
        $uri = $_SERVER['REQUEST_URI'];



        if (str_contains($uri, '/currentMonth')) {
            $dateParams = $this->balanceService->updateCurrentMonth();
            $_SESSION['viewMode'] = "currentMonth";
        }
        elseif (str_contains($uri, '/lastMonth')) {
            $dateParams = $this->balanceService->updateLastMonth();
            $_SESSION['viewMode'] = "lastMonth";
        }
        elseif (str_contains($uri, '/currentYear')) {
            $dateParams = $this->balanceService->updateCurrentYear();
            $_SESSION['viewMode'] = "currentYear";
        }
        elseif (str_contains($uri, '/customDates')) {
            echo $this->view->render("./balance/customDates.php");
            return;
        }
        else {

        }


        if (str_starts_with($uri, '/balanceAll')) {
            $userTransactions = $this->balanceService->getUserTransactions();
            $balanceMode = "detailed";
        }
        elseif (str_starts_with($uri, '/balanceCategory')) {
            $userTransactions = $this->balanceService->getUserTransactionsByCategories();
            $balanceMode = "category";
        }
        else {
            // $userTransactions = [];
            // $balanceMode = "unknown";
        }

       // dd($userTransactions);


            $params = array_merge(
            $userTransactions,
            //$this->balanceService->getUserTransactions(),
            $this->balanceService->getChartResults(),
            [
                'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
                'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
                'balanceMode' => $balanceMode
            ],
            $this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance.php", $params);

    }
}
