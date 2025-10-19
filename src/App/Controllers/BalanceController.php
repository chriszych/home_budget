<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
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
    }    

    public function show(array $params): void
    {
        $type = $params['type'];
        $period = $params['period'];

        $dateRange = $this->balanceService->getSqlDateRange($period);
        $userTransactions = $this->balanceService->getTransactionsData($type, $dateRange);
        $chartResults = $this->balanceService->getChartResults($dateRange['sqlDataLow'], $dateRange['sqlDataHi']);

        $this->renderBalancePage(
            array_merge(
            $userTransactions, 
            $chartResults, 
            [
            'sqlDataLow'    => date('d-m-Y',strtotime($dateRange['sqlDataLow'])),
            'sqlDataHi'     => date('d-m-Y',strtotime($dateRange['sqlDataHi'])),
            'balanceMode'       => $type,
            'currentViewmode'   => $period,
            ]));
    }

    public function custom(array $params): void
    {
        $type = $params['type'];
        $period = $params['period'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->validatorService->validateBalanceDates($_POST);
            $_SESSION['startDate'] = $_POST['startDate'];
            $_SESSION['endDate'] = $_POST['endDate'];

            $dateRange = $this->balanceService->getSqlDateRange($period,$_POST);
            $userTransactions = $this->balanceService->getTransactionsData($type, $dateRange);
            $chartResults = $this->balanceService->getChartResults($dateRange['sqlDataLow'], $dateRange['sqlDataHi']);

            $this->renderBalancePage(
                array_merge(
                    $userTransactions, 
                    $chartResults, 
                    [
                        'sqlDataLow'        => date('d-m-Y',strtotime($dateRange['sqlDataLow'])),
                        'sqlDataHi'         => date('d-m-Y',strtotime($dateRange['sqlDataHi'])),
                        'balanceMode'       => $type,
                        'currentViewmode'   => $period,
                ]));
            return;
        }

        echo $this->view->render("./balance/customDates.php", 
            [
                'balanceMode'       => $type,
                'currentViewmode'   => $period,
                ]);
        return;
    }

    private function renderBalancePage(array $params): void
    {
        echo $this->view->render("balance.php", $params);
    }
}
