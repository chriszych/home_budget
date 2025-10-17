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
      //  $_SESSION['viewMode'] = "CurrentMonth";
    }    

    // public function balanceAllView()
    // {   
    //     $_SESSION['viewMode'] = "CurrentMonth";

    //     $params = array_merge(
    //         $this->balanceService->getUserTransactions(),
    //         $this->balanceService->getChartResults(),
    //         [
    //             'dateLowLimit' => $this->balanceService->dateLowLimit,
    //             'dateHiLimit' => $this->balanceService->dateHiLimit,
    //         ],
    //         $this->balanceService->checkBalancePage()
    //     );

    //     echo $this->view->render("balance.php", $params);
    // }
    // public function balanceCategoryView()
    // {   
    //     $params = array_merge(
    //         $this->balanceService->GetUserTransactionsByCategories(),
    //         $this->balanceService->getChartResults(),
    //         [
    //             'dateLowLimit' => $this->balanceService->dateLowLimit,
    //             'dateHiLimit' => $this->balanceService->dateHiLimit,
    //         ],
    //         $this->balanceService->checkBalancePage()
    //     );

    //     echo $this->view->render("balance2.php", $params);

    // }

    public function customDatesView()
    {
        echo $this->view->render("./balance/customDates.php");
    }

    public function updateCustomDates()
    {

        $uri = $_SERVER['REQUEST_URI'];

        if (str_starts_with($uri, '/balanceAll')) {
            $balanceMode = "balanceAll";
        }
        elseif (str_starts_with($uri, '/balanceCategory')) {
            $balanceMode = "balanceCategory";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validatorService->validateBalanceDates($_POST);
            $_SESSION['startDate'] = $_POST['startDate'];
            $_SESSION['endDate'] = $_POST['endDate'];
            if (str_starts_with($uri, '/balanceCategory')) {
                $userTransactions = $this->balanceService->getUserTransactionsByCategories($_POST);
            } else {
                $userTransactions = $this->balanceService->getUserTransactions($_POST);
            }
        } else {
            if (str_starts_with($uri, '/balanceCategory')) {
                $userTransactions = $this->balanceService->getUserTransactionsByCategories([
                    'startDate' => $_SESSION['startDate'],
                    'endDate'=> $_SESSION['endDate']
                ]);
            } else {
                $userTransactions = $this->balanceService->getUserTransactions([
                    'startDate' => $_SESSION['startDate'],
                    'endDate'=> $_SESSION['endDate']
                    ]);
            }
        }

            $params = array_merge(

            $userTransactions,
            $this->balanceService->getChartResults(),
            [
                'dateLowLimit' => $this->balanceService->dateLowLimit,
                'dateHiLimit' => $this->balanceService->dateHiLimit,
                'balanceMode' => $balanceMode
            ],
            //$this->balanceService->checkBalancePage()
        );

        echo $this->view->render("balance.php", $params);
    }

    public function balanceView()
    {   
       
       
        $_SESSION['vievMode'] = "currentMonth";
        $uri = $_SERVER['REQUEST_URI'];
        //$uriSegments = explode('/', trim($uri, '/'));
        //$currentBalanceMode = $uriSegments[0] ?? null;

        if (str_contains($uri, '/currentMonth')) {
            $_SESSION['viewMode'] = "currentMonth";
            $this->balanceService->updateCurrentMonth();
        }
        elseif (str_contains($uri, '/lastMonth')) {
            $_SESSION['viewMode'] = "lastMonth";
            $this->balanceService->updateLastMonth();
            
        }
        elseif (str_contains($uri, '/currentYear')) {
            $_SESSION['viewMode'] = "currentYear";
            $this->balanceService->updateCurrentYear();
            
        }
        elseif (str_contains($uri, '/customDates')) {


            if (
                ($_SESSION['viewMode'] != "customDates") 
                || (isset($_SESSION['startDate']) && isset($_SESSION['endDate']))
                )
            {
                echo $this->view->render("./balance/customDates.php");
                $_SESSION['viewMode'] = "customDates";
                return;
            } 
            else
            {
                $this->updateCustomDates();
                return;
            }
        }
        else {
            //add this case
        }


        if (str_starts_with($uri, '/balanceAll')) {
            $userTransactions = $this->balanceService->getUserTransactions();
            $balanceMode = "balanceAll";
        }
        elseif (str_starts_with($uri, '/balanceCategory')) {
            $userTransactions = $this->balanceService->getUserTransactionsByCategories();
            $balanceMode = "balanceCategory";
        }
        else {
            //add this ccase
        }


            $params = array_merge(
            $userTransactions,
            $this->balanceService->getChartResults(),
            [
                'dateLowLimit' => $this->balanceService->dateLowLimit,
                'dateHiLimit' => $this->balanceService->dateHiLimit,
                'balanceMode' => $balanceMode
            ],
            //$this->balanceService->checkBalancePage()
        );

         $_SESSION['lastBalanceMode'] = $balanceMode;
         

        echo $this->view->render("balance.php", $params);

    }
}
