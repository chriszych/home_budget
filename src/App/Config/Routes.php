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
    // $app->get('/balanceAll/{viewMode}', [BalanceController::class, 'balanceAllView'])->add(AuthRequiredMiddleware::class);
    // $app->get('/balanceCategory/{viewMode}', [BalanceController::class, 'balanceCategoryView'])->add(AuthRequiredMiddleware::class);
    $app->get('/settings', [SettingsController::class, 'settings'])->add(AuthRequiredMiddleware::class);
    $app->get('/listIncomeCategory', [SettingsController::class, 'listIncomeView'])->add(AuthRequiredMiddleware::class);
    $app->get('/addIncomeCategory', [SettingsController::class, 'addIncomeView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addIncomeCategory', [SettingsController::class, 'addIncomeCategory'])->add(AuthRequiredMiddleware::class);
    $app->post('/deleteIncomeCategory', [SettingsController::class, 'deleteIncomeCategory'])->add(AuthRequiredMiddleware::class);
    $app->get('/editIncomeCategory/{category}', [SettingsController::class, 'editIncomeView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editIncomeCategory/{category}', [SettingsController::class, 'editIncomeCategory'])->add(AuthRequiredMiddleware::class);
    $app->get('/addExpenseCategory', [SettingsController::class, 'addExpenseView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addExpenseCategory', [SettingsController::class, 'addExpenseCategory'])->add(AuthRequiredMiddleware::class);
    $app->get('/listExpenseCategory', [SettingsController::class, 'listExpenseView'])->add(AuthRequiredMiddleware::class);
    $app->post('/deleteExpenseCategory', [SettingsController::class, 'deleteExpenseCategory'])->add(AuthRequiredMiddleware::class);
    $app->get('/editExpenseCategory/{category}', [SettingsController::class, 'editExpenseView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editExpenseCategory/{category}', [SettingsController::class, 'editExpenseCategory'])->add(AuthRequiredMiddleware::class);
    $app->get('/listPaymentMethod', [SettingsController::class, 'listPaymentView'])->add(AuthRequiredMiddleware::class);
    $app->get('/editPaymentMethod/{category}', [SettingsController::class, 'editPaymentView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editPaymentMethod/{category}', [SettingsController::class, 'editPaymentMethod'])->add(AuthRequiredMiddleware::class);
    $app->get('/addPaymentMethod', [SettingsController::class, 'addPaymentView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addPaymentMethod', [SettingsController::class, 'addPaymentMethod'])->add(AuthRequiredMiddleware::class);
    $app->post('/deletePaymentMethod', [SettingsController::class, 'deletePaymentMethod'])->add(AuthRequiredMiddleware::class);
    $app->get('/editUser', [SettingsController::class, 'editUserView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editUser', [SettingsController::class, 'updateUser'])->add(AuthRequiredMiddleware::class);
    $app->get('/changePassword', [SettingsController::class, 'changePasswordView'])->add(AuthRequiredMiddleware::class);
    $app->post('/changePassword', [SettingsController::class, 'updatePassword'])->add(AuthRequiredMiddleware::class);
    $app->get('/AfterPassChangeInfo', [SettingsController::class, 'infoAfterPassChange'])->add(AuthRequiredMiddleware::class);
    $app->get('/AfterUserChangeInfo', [SettingsController::class, 'infoAfterUserChange'])->add(AuthRequiredMiddleware::class);
    $app->get('/deleteUser', [SettingsController::class, 'confirmView'])->add(AuthRequiredMiddleware::class);
    $app->get('/dropUser', [SettingsController::class, 'deleteUserData'])->add(AuthRequiredMiddleware::class);
    $app->get('/{balanceType:balanceAll|balanceCategory}/{viewMode:currentMonth|currentYear|lastMonth|customDates}', [BalanceController::class, 'balanceView'])->add(AuthRequiredMiddleware::class);
    // $app->get('/{balanceType}/customDates', [BalanceController::class, 'customDatesView'])->add(AuthRequiredMiddleware::class);
    $app->post('/{balanceType:balanceAll|balanceCategory}/customDates', [BalanceController::class, 'updateCustomDates'])->add(AuthRequiredMiddleware::class);
    // $app->get('/{balanceType}/currentYear', [BalanceController::class, 'updateCurrentYear'])->add(AuthRequiredMiddleware::class);
    // $app->get('/{balanceType}/lastMonth', [BalanceController::class, 'updateLastMonth'])->add(AuthRequiredMiddleware::class);
    // $app->get('/currentMonth', [BalanceController::class, 'updateCurrentMonth'])->add(AuthRequiredMiddleware::class);
    //currentYear
    //currentMonth
    //lastMonth
}