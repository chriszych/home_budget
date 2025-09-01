<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{

    private $firstCurrentMonthDay;
	private $lastCurrentMonthDay;
	private $sqlMonthHiLimit;
	private $sqlMonthLowLimit;
    
    public function __construct(private Database $db)
    {

    $this -> firstCurrentMonthDay = date('01-m-Y');
	$this -> lastCurrentMonthDay = date('t-m-Y');
	$this -> sqlMonthHiLimit = date('Y-m-t 23:59:59');
	$this -> sqlMonthLowLimit = date('Y-m-01 00:00:00'); 

    }

    private function getChartResults() :Array
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

        return $chartResults;
    }

    public function GetUserTransactions() : Array
    {

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

        $chartResults = BalanceService::getChartResults();

        return [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'chartResults' => $chartResults,
            'firstCurrentMonthDay' => $this -> firstCurrentMonthDay,
            'lastCurrentMonthDay' => $this -> lastCurrentMonthDay
        ];

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

        $chartResults = BalanceService::getChartResults();

        return [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'chartResults' => $chartResults,
            'firstCurrentMonthDay' => $this -> firstCurrentMonthDay,
            'lastCurrentMonthDay' => $this -> lastCurrentMonthDay
        ];
    }




}