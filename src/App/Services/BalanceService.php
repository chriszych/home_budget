<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{

    // public $dateLowLimit; //$firstCurrentMonthDay;
	// public $dateHiLimit; //$lastCurrentMonthDay;
	// private $sqlDateHiLimit; //$sqlMonthHiLimit;
	// private $sqlDateLowLimit; //$sqlMonthLowLimit;
    
    public function __construct(private Database $db)
    {

    // $this -> dateLowLimit = date('01-m-Y');
	// $this -> dateHiLimit = date('t-m-Y');
	// $this -> sqlDateHiLimit = date('Y-m-t 23:59:59');
	// $this -> sqlDateLowLimit = date('Y-m-01 00:00:00'); 

    }

    public function getChartResults(string $sqlDataLow, string $sqlDataHi) :Array
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
            $messageMain = "Gratulacje!!!";
            $messageText = "Świetnie zarządzasz swoimi finansami :)";
            $messageColor = "text-success";
            $messageBackground = "text-bg-success border-success";
        }  
        else
        {
            $messageMain = "Uwaga!!!";
            $messageText = "Ostrożnie, wpadasz w długi :(";
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

    // public function getUserTransactions(array $formData = []) : Array
    // {

        // if ((!empty($formData['startDate']))&&(!empty($formData['endDate'])))
        // {
        // $this -> dateLowLimit = date('d-m-Y', strtotime($formData['startDate']));
        // $this -> dateHiLimit = date('d-m-Y', strtotime($formData['endDate']));
        // $this -> sqlDateLowLimit = "{$formData['startDate']}:00"; 
        // $this -> sqlDateHiLimit = "{$formData['endDate']}:00";
        // }

        // $resultExp = $this->db->query(
        //     "SELECT id_exp, exp_date, exp_amount, exp_cat_name, pay_met_name, exp_comment 
        //     FROM expense 
        //     JOIN expense_user_category 
        //     ON id_exp_cat = id_exp_user_cat 
        //     JOIN payment_user_method 
        //     ON id_pay_met = id_user_pay_met 
        //     WHERE expense.id_user=:id_user 
        //     AND exp_date BETWEEN :low_limit AND :hi_limit 
        //     ORDER BY exp_date",
        //     [
        //         'id_user' => $_SESSION['user'],
        //         'low_limit' => $this -> sqlDateLowLimit,
        //         'hi_limit' => $this -> sqlDateHiLimit
        //     ] 
        // )->findAll();

        
        // $resultInc = $this->db->query(
        //     "SELECT id_inc, inc_date, inc_amount, inc_cat_name, inc_comment 
        //     FROM income 
        //     JOIN income_user_category 
        //     ON id_inc_cat = id_inc_user_cat 
        //     WHERE income.id_user=:id_user 
        //     AND inc_date 
        //     BETWEEN :low_limit 
        //     AND :hi_limit 
        //     ORDER BY inc_date",
        //     [
        //         'id_user' => $_SESSION['user'],
        //         'low_limit' => $this -> sqlDateLowLimit,
        //         'hi_limit' => $this -> sqlDateHiLimit
        //     ] 
        // )->findAll();

    //     $incSum = array_sum(array_column($resultInc, 'inc_amount'));
    //     $expSum = array_sum(array_column($resultExp, 'exp_amount'));
    //     $balance = $incSum - $expSum;

    //     $calcParams = $this->addBalanceTexts($balance);
    //     $resultParams = [
    //         'resultExp' => $resultExp,
    //         'resultInc' => $resultInc,
    //         'incSum' => $incSum,
    //         'expSum' => $expSum,
    //         'balance' => $balance
    //     ];
    //     $params = array_merge($calcParams, $resultParams);
    //     return $params;

    // }

    // public function getUserTransactionsByCategories(array $formData = []) : Array
    // {
        
        // if ((!empty($formData['startDate']))&&(!empty($formData['endDate'])))
        // {
        // $this -> dateLowLimit = date('d-m-Y', strtotime($formData['startDate']));
        // $this -> dateHiLimit = date('d-m-Y', strtotime($formData['endDate']));
        // $this -> sqlDateLowLimit = "{$formData['startDate']}:00"; 
        // $this -> sqlDateHiLimit = "{$formData['endDate']}:00";
        // }
        
        
        // $resultExp = $this->db->query(
        //     "SELECT SUM(exp_amount) AS total_amount, exp_cat_name 
        //     FROM expense 
        //     JOIN expense_user_category ON id_exp_cat = id_exp_user_cat 
        //     WHERE expense.id_user=:id_user AND exp_date BETWEEN :low_limit AND :hi_limit 
        //     GROUP BY exp_cat_name ORDER BY total_amount DESC",
        //     [
        //         'id_user' => $_SESSION['user'],
        //         'low_limit' => $this -> sqlDateLowLimit,
        //         'hi_limit' => $this -> sqlDateHiLimit
        //     ]
        // )->findAll();

        // $resultInc = $this->db->query(
        //     "SELECT SUM(inc_amount) AS total_amount, inc_cat_name 
        //     FROM income 
        //     JOIN income_user_category ON id_inc_cat = id_inc_user_cat 
        //     WHERE income.id_user=:id_user AND inc_date BETWEEN :low_limit AND :hi_limit 
        //     GROUP BY inc_cat_name 
        //     ORDER BY total_amount DESC",
        //     [
        //         'id_user' => $_SESSION['user'],
        //         'low_limit' => $this -> sqlDateLowLimit,
        //         'hi_limit' => $this -> sqlDateHiLimit
        //     ]
        // )->findAll();

	// 	 $incSum = array_sum(array_column($resultInc, 'total_amount'));
    //      $expSum = array_sum(array_column($resultExp, 'total_amount'));	
    //      $balance = $incSum - $expSum;

    //     $calcParams = $this->addBalanceTexts($balance);
    //     $resultParams = [
    //         'resultExp' => $resultExp,
    //         'resultInc' => $resultInc,
    //         'incSum' => $incSum,
    //         'expSum' => $expSum,
    //         'balance' => $balance,
    //     ];
    //     $params = array_merge($calcParams, $resultParams);
        
    //     return $params;
    // }

    // public function updateCurrentYear()
    // {
    //     $this -> dateLowLimit = date('01-01-Y');
    //     $this -> dateHiLimit = date('t-12-Y');
    //     $this -> sqlDateHiLimit = date('Y-12-t 23:59:59');
    //     $this -> sqlDateLowLimit = date('Y-01-01 00:00:00'); 
    // }

    // public function updateLastMonth()
    // {
    //     $this -> dateLowLimit = date('01-m-Y', strtotime("-1 month"));
    //     $this -> dateHiLimit = date('t-m-Y', strtotime("-1 month"));
    //     $this -> sqlDateHiLimit = date('Y-n-t 23:59:59', strtotime("-1 month"));
    //     $this -> sqlDateLowLimit = date('Y-n-01 00:00:00', strtotime("-1 month")); 
    // }
    
    // public function updateCurrentMonth()
    // {
    //     $this -> dateLowLimit = date('01-m-Y');
    //     $this -> dateHiLimit = date('t-m-Y');
    //     $this -> sqlDateHiLimit = date('Y-m-t 23:59:59');
    //     $this -> sqlDateLowLimit = date('Y-m-01 00:00:00'); 
    // }

    public function getSqlDateRange(string $period, array $customDates = []): array
    {
        if ($period === 'custom' && !empty($customDates['startDate'])) {
            // Logika custom: konwersja dat z formularza na format SQL
            $sqlDataLow = "{$customDates['startDate']}:00"; 
            $sqlDataHi = "{$customDates['endDate']}:00";
        } else {
            // Logika dla standardowych okresów:
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
                // ... reszta okresów
                default: // Domyślnie obecny miesiąc
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
    // 1. Obliczenie dat
    //$dateRange = $this->getSqlDateRange($period, $customDates);
    
    // 2. Wybór zapytania na podstawie $type
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
        );
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
        );
    } else { // balanceAll
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
            ] 
        );
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
            ] 
        );
    }

    // 3. Obliczenie i formatowanie wyników
    return $this->calculateAndFormatResults($resultInc->findAll(), $resultExp->findAll(), $type);
}

private function calculateAndFormatResults(array $resultInc, array $resultExp, string $type): array
{
    // Ustalenie, która kolumna zawiera kwotę, w zależności od trybu
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