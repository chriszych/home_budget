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
    $userId = (int)$_SESSION['user'];
    $data = $this->transactionService->getUserExpensePayment($userId);
    $timeData = getNowNextYear();
    $params = array_merge($data, $timeData); 

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
    $userId = (int)$_SESSION['user']; 
    $incomeCategories = $this->transactionService->getUserIncomeCategory($userId);
    $timeData = getNowNextYear();
    $params = [
        'incomeCategories' => $incomeCategories,
        ...$timeData
    ];

    echo $this->view->render("transactions/addIncome.php", $params);
  }

    public function addIncome()
    {
    $this->validatorService->validateIncome($_POST);
    $this->transactionService->insertIncome($_POST);

    redirectTo('/addIncome');
    }

}