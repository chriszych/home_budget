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
        
        $params = array_merge(
            $this->userService->getLoggedUserData(),
            $this->balanceService->GetUserTransactionsByCategories()
        );
        
        echo $this->view->render("main.php", $params);
        
    }
}
