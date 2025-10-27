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
            'view'              => 'transactions/addTransaction.php',
            'service_insert'    => 'insertIncome',
            'service_validate'  => 'validateIncome',
            'view_data_key'     => 'incomeCategories',
            'redirect_to'       => '/addTransaction/income'
        ],
        'expense' => [
          'view'              => 'transactions/addTransaction.php',
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

    $data = $this->transactionService->getFormDataForType($type, $userId);
    $timeData = getNowNextYear();

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
    
    $this->validatorService->{$map['service_validate']}($_POST);
    $this->transactionService->{$map['service_insert']}($_POST);

    redirectTo($map['redirect_to']); 
}


}