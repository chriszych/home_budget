<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

use App\Services\UserService;



class MainController
{
    
    public function __construct(
        private TemplateEngine $view,
        private UserService $userService
        )
    {
        
    }    

    public function mainView()
    {   
        
        $params = $this->userService->getUserBalance();
        
        echo $this->view->render("main.php", $params);
        
    }
}
