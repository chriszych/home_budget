<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{
    public function __construct(private Database $db)
    {
        
    }

    public function GetUserTransactions() : Array
    {
        $firstCurrentMonthDay = date('01-m-Y');
	    $lastCurrentMonthDay = date('t-m-Y');
	    $sqlMonthHiLimit = date('Y-m-t 23:59:59');
	    $sqlMonthLowLimit = date('Y-m-01 00:00:00');

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
                'low_limit' => $sqlMonthLowLimit,
                'hi_limit' => $sqlMonthHiLimit
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
                'low_limit' => $sqlMonthLowLimit,
                'hi_limit' => $sqlMonthHiLimit
            ] 
        )->findAll();

    
        return [
            'resultExp' => $resultExp,
            'resultInc' => $resultInc,
            'firstCurrentMonthDay' => $firstCurrentMonthDay,
            'lastCurrentMonthDay' => $lastCurrentMonthDay
        ];

    }


}