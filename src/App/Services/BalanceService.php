<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{

    public $firstCurrentMonthDay;
	public $lastCurrentMonthDay;
	private $sqlMonthHiLimit;
	private $sqlMonthLowLimit;
    
    public function __construct(private Database $db)
    {

    $this -> firstCurrentMonthDay = date('01-m-Y');
	$this -> lastCurrentMonthDay = date('t-m-Y');
	$this -> sqlMonthHiLimit = date('Y-m-t 23:59:59');
	$this -> sqlMonthLowLimit = date('Y-m-01 00:00:00'); 

    }

    public function getChartResults() :Array
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
                'low_limit' => $this -> sqlMonthLowLimit,
                'hi_limit' => $this -> sqlMonthHiLimit
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

    public function GetUserTransactions(array $formData = []) : Array
    {

        if ((!empty($formData['startDate']))&&(!empty($formData['endDate'])))
        {
        $this -> firstCurrentMonthDay = date('d-m-Y', strtotime($formData['startDate']));
        $this -> lastCurrentMonthDay = date('d-m-Y', strtotime($formData['endDate']));
        $this -> sqlMonthLowLimit = "{$formData['startDate']}:00"; 
        $this -> sqlMonthHiLimit = "{$formData['endDate']}:00";
        }

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
                'low_limit' => $this -> sqlMonthLowLimit,
                'hi_limit' => $this -> sqlMonthHiLimit
            ] 
        )->findAll();

        
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
                'low_limit' => $this -> sqlMonthLowLimit,
                'hi_limit' => $this -> sqlMonthHiLimit
            ] 
        )->findAll();

        $incSum = array_sum(array_column($resultInc, 'inc_amount'));
        $expSum = array_sum(array_column($resultExp, 'exp_amount'));
        $balance = $incSum - $expSum;

        $calcParams = $this->addBalanceTexts($balance);
        $resultParams = [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'incSum' => $incSum,
            'expSum' => $expSum,
            'balance' => $balance
        ];
        $params = array_merge($calcParams, $resultParams);
        return $params;

    }

    public function GetUserTransactionsByCategories() : Array
    {
        $resultExp = $this->db->query(
            "SELECT SUM(exp_amount) AS total_amount, exp_cat_name 
            FROM expense 
            JOIN expense_user_category ON id_exp_cat = id_exp_user_cat 
            WHERE expense.id_user=:id_user AND exp_date BETWEEN :low_limit AND :hi_limit 
            GROUP BY exp_cat_name ORDER BY total_amount DESC",
            [
                'id_user' => $_SESSION['user'],
                'low_limit' => $this -> sqlMonthLowLimit,
                'hi_limit' => $this -> sqlMonthHiLimit
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
                'low_limit' => $this -> sqlMonthLowLimit,
                'hi_limit' => $this -> sqlMonthHiLimit
            ]
        )->findAll();

		 $incSum = array_sum(array_column($resultInc, 'total_amount'));
         $expSum = array_sum(array_column($resultExp, 'total_amount'));	
         $balance = $incSum - $expSum;

        $calcParams = $this->addBalanceTexts($balance);
        $resultParams = [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'incSum' => $incSum,
            'expSum' => $expSum,
            'balance' => $balance,
        ];
        $params = array_merge($calcParams, $resultParams);
        
        return $params;
    }

    public function checkBalancePage() : Array
    {
        $path = $_SERVER['REQUEST_URI'];
        $isBalance2 = strpos($path, '/balance2') !== false;

        if ($isBalance2)
            {
               $Balance2Button =  "btn-primary";
               $Balance1Button =  "btn-outline-primary";
            } else {
                $Balance1Button =  "btn-primary";
                $Balance2Button =  "btn-outline-primary";
            }
        return 
        [
            'Balance1Button' => $Balance1Button,
            'Balance2Button' => $Balance2Button
        ];
    }

    public function updateCurrentYear()
    {
        $this -> firstCurrentMonthDay = date('01-01-Y');
        $this -> lastCurrentMonthDay = date('t-12-Y');
        $this -> sqlMonthHiLimit = date('Y-12-t 23:59:59');
        $this -> sqlMonthLowLimit = date('Y-01-01 00:00:00'); 
    }

    public function updateLastMonth()
    {
        $this -> firstCurrentMonthDay = date('01-m-Y', strtotime("-1 month"));
        $this -> lastCurrentMonthDay = date('t-m-Y', strtotime("-1 month"));
        $this -> sqlMonthHiLimit = date('Y-n-t 23:59:59', strtotime("-1 month"));
        $this -> sqlMonthLowLimit = date('Y-n-01 00:00:00', strtotime("-1 month")); 
    }
    
    public function updateCurrentMonth()
    {
        $this -> firstCurrentMonthDay = date('01-m-Y');
        $this -> lastCurrentMonthDay = date('t-m-Y');
        $this -> sqlMonthHiLimit = date('Y-m-t 23:59:59');
        $this -> sqlMonthLowLimit = date('Y-m-01 00:00:00'); 
    }
    //updateLastMonth



}