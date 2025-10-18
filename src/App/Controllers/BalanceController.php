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

        // match ($period) {
        //     'current-month' => $this->balanceService->updateCurrentMonth(),
        //     'last-month'    => $this->balanceService->updateLastMonth(),
        //     'current-year'  => $this->balanceService->updateCurrentYear(),
        // };

        $dateRange = $this->balanceService->getSqlDateRange($period);

        $userTransactions = $this->balanceService->getTransactionsData($type, $dateRange);

        $chartResults = $this->balanceService->getChartResults($dateRange['sqlDataLow'], $dateRange['sqlDataHi']);

        $this->renderBalancePage(
            array_merge(
            $userTransactions, 
            $chartResults, 
            $dateRange,
            [
            //'type' => $type, 
            //'period' => $period
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

            $dateRange = $this->balanceService->getSqlDateRange($period);
            //$userTransactions = $this->fetchTransactionsForType($type, $_POST);
            $userTransactions = $this->balanceService->getTransactionsData($type, $_POST);
            $chartResults = $this->balanceService->getChartResults($_POST['startDate'], $_POST['endDate']);
            //$this->renderBalancePage($userTransactions, $type, $period);
                    $this->renderBalancePage(
            array_merge(
            $userTransactions, 
            $chartResults, 
            $dateRange,
            [
            //'type' => $type, 
            //'period' => $period
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

    // private function fetchTransactionsForType(string $type, ?array $dates = []): array
    // {
    //     return match ($type) {

    //         'balanceAll'      => $this->balanceService->getUserTransactions($dates),
    //         'balanceCategory' => $this->balanceService->getUserTransactionsByCategories($dates),
    //     };
    // }

    // private function renderBalancePage(array $userTransactions, array $chartResults, string $balanceMode, string $period): void
    private function renderBalancePage(array $params): void
    {
        // $dateRange = $this->balanceService->getSqlDateRange($period);

        // $params = array_merge(
        //     $userTransactions,
        //     $chartResults,
        //     [
        //         'dateLowLimit'    => $dateRange['sqlDataLow'],
        //         'dateHiLimit'     => $dateRange['sqlDataHi'],
        //         'balanceMode'     => $balanceMode,
        //         'currentViewmode' => $period
        //     ]
        // );

        echo $this->view->render("balance.php", $params);
    }
}
