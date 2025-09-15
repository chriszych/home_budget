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
        
        $params1 = $this->userService->getLoggedUserData();
        $params2 = $this->balanceService->GetUserTransactionsByCategories();
        $params = array_merge($params1, $params2);
        
        echo $this->view->render("main.php", $params);
        
    }
}
