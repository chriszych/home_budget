<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
    AuthController,
    TransactionController,
    ErrorController,
    IndexController,
    MainController,
    BalanceController,
    SettingsController
    };

use App\Middleware\{
    AuthRequiredMiddleware, 
    GuestOnlyMiddleware
    };

function registerRoutes(App $app) 
{

    $app->setErrorHandler([ErrorController::class, 'notFound']);

    $app->get('/', [IndexController::class, 'index'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/main', [MainController::class, 'mainView'])->add(AuthRequiredMiddleware::class);
    $app->get('/logout', [AuthController::class, 'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/addExpense', [TransactionController::class, 'addExpenseView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addExpense', [TransactionController::class, 'addExpense'])->add(AuthRequiredMiddleware::class);
    $app->get('/addIncome', [TransactionController::class, 'addIncomeView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addIncome', [TransactionController::class, 'addIncome'])->add(AuthRequiredMiddleware::class);
    $app->get('/balance', [BalanceController::class, 'balanceView'])->add(AuthRequiredMiddleware::class);
    $app->get('/balance2', [BalanceController::class, 'balance2View'])->add(AuthRequiredMiddleware::class);
    $app->get('/settings', [SettingsController::class, 'settings'])->add(AuthRequiredMiddleware::class);
}