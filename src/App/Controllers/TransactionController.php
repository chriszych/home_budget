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

  private function getTransactionMap(string $type): ?array
{
    $map = [
        'income' => [
            //'view'              => 'transactions/addIncome.php', // Wymaga uogólnienia widoku!
            'view'              => 'transactions/addTransaction.php',
            //'service_data'      => 'getUserIncomeCategory', // w TransactionService
            'service_insert'    => 'insertIncome', // w TransactionService
            'service_validate'  => 'validateIncome', // w ValidatorService
            'view_data_key'     => 'incomeCategories',
            'redirect_to'       => '/addTransaction/income'
        ],
        'expense' => [
          'view'              => 'transactions/addTransaction.php',
            //'view'              => 'transactions/addExpense.php', // Wymaga uogólnienia widoku!
            //'service_data'      => 'getUserExpensePayment', // w TransactionService
            'service_insert'    => 'insertExpense',
            'service_validate'  => 'validateExpense',
            'view_data_key'     => 'expenseCategories', 
            'redirect_to'       => '/addTransaction/expense'
        ],
    ];
    return $map[$type] ?? null;
}

private function getUserId(): int
{
    return (int)$_SESSION['user'];
}

public function addTransactionView(array $params)
{
    $type = $params['type']; 
    $userId = $this->getUserId();
    $map = $this->getTransactionMap($type);
    //$userId = (int)$_SESSION['user'];

    //$data = $this->transactionService->{$map['service_data']}($userId);
    $data = $this->transactionService->getFormDataForType($type, $userId);
    $timeData = getNowNextYear();

    //$viewData = ($type === 'expense') ? $data : [$map['view_data_key'] => $data];
    //$params = array_merge($viewData, $timeData); 

    //echo $this->view->render($map['view'], $params);
    echo $this->view->render($map['view'], [
        'type' => $type,
        ...$data, 
        ...$timeData
    ]);
}

public function handleTransactionAdd(array $params)
{
    $type = $params['type'];
    $map = $this->getTransactionMap($type);
    
    //dd($_POST);
    $this->validatorService->{$map['service_validate']}($_POST);
    $this->transactionService->{$map['service_insert']}($_POST);

    redirectTo($map['redirect_to']); 
}

  // public function addExpenseView()
  // {
  //   $userId = (int)$_SESSION['user'];
  //   $data = $this->transactionService->getUserExpensePayment($userId);
  //   $timeData = getNowNextYear();
  //   $params = array_merge($data, $timeData); 

  //   echo $this->view->render("transactions/addExpense.php", $params);
  // }

  // public function addExpense() 
  // {
  //   $this->validatorService->validateExpense($_POST);
  //   $this->transactionService->insertExpense($_POST);

  //   redirectTo('/addExpense');
  // }

  // public function addIncomeView()
  // {
  //   $userId = (int)$_SESSION['user']; 
  //   $incomeCategories = $this->transactionService->getUserIncomeCategory($userId);
  //   $timeData = getNowNextYear();
  //   $params = [
  //       'incomeCategories' => $incomeCategories,
  //       ...$timeData
  //   ];

  //   echo $this->view->render("transactions/addIncome.php", $params);
  // }

  //   public function addIncome()
  //   {
  //   $this->validatorService->validateIncome($_POST);
  //   $this->transactionService->insertIncome($_POST);

  //   redirectTo('/addIncome');
  //   }

}