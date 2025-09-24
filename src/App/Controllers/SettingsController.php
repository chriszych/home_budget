<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;


class SettingsController
{
    
    public function __construct(private TemplateEngine $view)
    {

    }    

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }
}
