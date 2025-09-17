<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, TransactionService};

class TransactionController
{
  public function __construct(
    private TemplateEngine $view,
    private ValidatorService $validatorService,
    private TransactionService $transactionService
  ) {
  }

  public function addExpenseView()
  {
    
    $params = $this->transactionService->getUserExpensePayment((int)$_SESSION['user']);  

    echo $this->view->render("transactions/addExpense.php", $params);
  }

  public function addExpense() 
  {
    $this->validatorService->validateExpense($_POST);

    $this->transactionService->insertExpense($_POST);

    redirectTo('/addExpense');
  }

  public function addIncomeView()
  {
    $params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

    echo $this->view->render("transactions/addIncome.php", $params);
  }

    public function addIncome()
    {
    $this->validatorService->validateIncome($_POST);

    $this->transactionService->insertIncome($_POST);

    redirectTo('/addIncome');
    }

}