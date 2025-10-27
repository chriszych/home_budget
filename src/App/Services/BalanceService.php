<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{
    
    public function __construct(private Database $db)
    {

    }

    public function getChartResults(string $sqlDataLow, string $sqlDataHi) :array
    {
            $chartResults = $this->db->query(
            "SELECT exp_cat_name, SUM(exp_amount) AS total_amount 
            FROM expense 
            JOIN expense_user_category ON id_exp_cat = id_exp_user_cat 
            WHERE expense.id_user = :id_user AND exp_date BETWEEN :low_limit AND :hi_limit 
            GROUP BY exp_cat_name 
            ORDER BY total_amount DESC",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $sqlDataLow,
                'hi_limit' => $sqlDataHi
            ]
        )->findAll();

        $labels = [];
        $data = [];
        foreach ($chartResults as $row) {
        $labels[] = $row['exp_cat_name'];
	    $data[] = (float)$row['total_amount'];
        }

        return [
            'chartLabels' => $labels,
            'chartData' => $data
        ];
    }

    public function addBalanceTexts(float $balance) : Array
    {
        if($balance > 0)
        {
            $messageMain = "Congratulations!!!";
            $messageText = "You're doing great with your finances :)";
            $messageColor = "text-success";
            $messageBackground = "text-bg-success border-success";
        }  
        else
        {
            $messageMain = "Caution!!!";
            $messageText = "Be careful, you're going into debt :(";
            $messageColor = "text-danger";
            $messageBackground = "text-bg-danger border-danger";
        }

        return [
            'messageMain' => $messageMain,
            'messageText' => $messageText,
            'messageColor' => $messageColor,
            'messageBackground' => $messageBackground
        ];
    }

    public function getSqlDateRange(string $period, array $customDates = []): array
    {

        if ($period === 'custom' && !empty($customDates['startDate'])) {

            $sqlDataLow = "{$customDates['startDate']}:00"; 
            $sqlDataHi = "{$customDates['endDate']}:00";

        } else {
            switch ($period) {
                case 'current-month':
                    $sqlDataLow = date('Y-m-01 00:00:00');
                    $sqlDataHi = date('Y-m-t 23:59:59');
                    break;
                case 'last-month':
                    $sqlDataLow = date('Y-m-01 00:00:00', strtotime("-1 month"));
                    $sqlDataHi = date('Y-m-t 23:59:59', strtotime("-1 month"));
                    break;
                case 'current-year':
                    $sqlDataLow = date('Y-01-01 00:00:00');
                    $sqlDataHi = date('Y-12-t 23:59:59');
                    break;
                default:
                    $sqlDataLow = date('Y-m-01 00:00:00');
                    $sqlDataHi = date('Y-m-t 23:59:59');
            }
        }
        return [
            'sqlDataLow' => $sqlDataLow, 
            'sqlDataHi' => $sqlDataHi
            ];
    }

    public function getTransactionsData(string $type, array $dateRange): array
    {

    if ($type === 'balanceCategory') {
        $resultExp = $this->db->query(
            "SELECT SUM(exp_amount) AS total_amount, exp_cat_name 
            FROM expense 
            JOIN expense_user_category ON id_exp_cat = id_exp_user_cat 
            WHERE expense.id_user=:id_user AND exp_date BETWEEN :low_limit AND :hi_limit 
            GROUP BY exp_cat_name ORDER BY total_amount DESC",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $dateRange['sqlDataLow'],
                'hi_limit' => $dateRange['sqlDataHi']
            ]
        )->findAll();

        $resultInc = $this->db->query(
            "SELECT SUM(inc_amount) AS total_amount, inc_cat_name 
            FROM income 
            JOIN income_user_category ON id_inc_cat = id_inc_user_cat 
            WHERE income.id_user=:id_user AND inc_date BETWEEN :low_limit AND :hi_limit 
            GROUP BY inc_cat_name 
            ORDER BY total_amount DESC",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $dateRange['sqlDataLow'],
                'hi_limit' => $dateRange['sqlDataHi']
            ]
        )->findAll();

        } else {
            $resultExp = $this->db->query(
            "SELECT id_exp, exp_date, exp_amount, exp_cat_name, pay_met_name, exp_comment 
            FROM expense 
            JOIN expense_user_category 
            ON id_exp_cat = id_exp_user_cat 
            JOIN payment_user_method 
            ON id_pay_met = id_user_pay_met 
            WHERE expense.id_user=:id_user 
            AND exp_date BETWEEN :low_limit AND :hi_limit 
            ORDER BY exp_date",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $dateRange['sqlDataLow'],
                'hi_limit' => $dateRange['sqlDataHi']
            ])->findAll();

            $resultInc = $this->db->query(
            "SELECT id_inc, inc_date, inc_amount, inc_cat_name, inc_comment 
            FROM income 
            JOIN income_user_category 
            ON id_inc_cat = id_inc_user_cat 
            WHERE income.id_user=:id_user 
            AND inc_date 
            BETWEEN :low_limit 
            AND :hi_limit 
            ORDER BY inc_date",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $dateRange['sqlDataLow'],
                'hi_limit' => $dateRange['sqlDataHi']
            ])->findAll();
        }

    return $this->calculateAndFormatResults($resultExp, $resultInc, $type);
    }

    private function calculateAndFormatResults(array $resultExp, array $resultInc, string $type): array
    {

        $incAmountKey = ($type === 'balanceAll') ? 'inc_amount' : 'total_amount';
        $expAmountKey = ($type === 'balanceAll') ? 'exp_amount' : 'total_amount';
        
        $incSum = array_sum(array_column($resultInc, $incAmountKey));
        $expSum = array_sum(array_column($resultExp, $expAmountKey));
        $balance = $incSum - $expSum;

        $calcParams = $this->addBalanceTexts($balance);
        $resultParams = [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'incSum' => $incSum,
            'expSum' => $expSum,
            'balance' => $balance
        ];
        
        return array_merge($calcParams, $resultParams);
    }

}