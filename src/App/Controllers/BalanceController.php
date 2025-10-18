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

        match ($period) {
            'current-month' => $this->balanceService->updateCurrentMonth(),
            'last-month'    => $this->balanceService->updateLastMonth(),
            'current-year'  => $this->balanceService->updateCurrentYear(),
            default         => $this->balanceService->updateCurrentMonth(),
        };

        $userTransactions = $this->fetchTransactionsForType($type);

        $this->renderBalancePage($userTransactions, $type, $period);
    }

    public function custom(array $params): void
    {
        $type = $params['type'];
        $period = $params['period'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->validatorService->validateBalanceDates($_POST);
            $_SESSION['startDate'] = $_POST['startDate'];
            $_SESSION['endDate'] = $_POST['endDate'];

            $userTransactions = $this->fetchTransactionsForType($type, $_POST);
            $this->renderBalancePage($userTransactions, $type, $period);
            return;
        }

        echo $this->view->render("./balance/customDates.php", 
            [
                'balanceMode'       => $type,
                'currentViewmode'    => $period,
                ]);
        return;
    }

    private function fetchTransactionsForType(string $type, ?array $dates = []): array
    {
        return match ($type) {

            'balanceAll'      => $this->balanceService->getUserTransactions($dates),
            'balanceCategory' => $this->balanceService->getUserTransactionsByCategories($dates),
            // Można rzucić wyjątek dla nieznanego typu
            default    => [], 
        };
    }

    private function renderBalancePage(array $userTransactions, string $balanceMode, string $currentViewmode): void
    {
        $params = array_merge(
            $userTransactions,
            $this->balanceService->getChartResults(),
            [
                'dateLowLimit' => $this->balanceService->dateLowLimit,
                'dateHiLimit'  => $this->balanceService->dateHiLimit,
                'balanceMode'  => $balanceMode,
                'currentViewmode' => $currentViewmode
            ]
        );

        echo $this->view->render("balance.php", $params);
    }
}
