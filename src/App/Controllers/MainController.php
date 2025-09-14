<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

use App\Services\UserService;
use App\Services\BalanceService;



class MainController
{
    
    public function __construct(
        private TemplateEngine $view,
        private UserService $userService,
        private BalanceService $balanceService
        )
    {
        
    }    

    public function mainView()
    {   
        
        $params1 = $this->userService->getUserBalance();
        $params2 = $this->balanceService->GetUserTransactionsByCategories();
        $params = array_merge($params1, $params2);
        
        echo $this->view->render("main.php", $params);

        // $params1 = $this->balanceService->GetUserTransactionsByCategories();
        // $params2 = $this->balanceService->getChartResults();
        // $params3 = [
        //     'firstCurrentMonthDay' => $this->balanceService->firstCurrentMonthDay,
        //     'lastCurrentMonthDay' => $this->balanceService->lastCurrentMonthDay,
        // ];

        // //dd($params1);
        // $params = array_merge($params1, $params2, $params3);
        //  //dd($params);

        // echo $this->view->render("balance2.php", $params);
        
    }
}
