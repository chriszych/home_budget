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
    $categoryTypes = 'income|expense|paymentMethod';
    $app->setErrorHandler([ErrorController::class, 'notFound']);

    $app->get('/', [IndexController::class, 'index'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/main', [MainController::class, 'mainView'])->add(AuthRequiredMiddleware::class);
    $app->get('/logout', [AuthController::class, 'logout'])->add(AuthRequiredMiddleware::class);

    $app->get('/settings', [SettingsController::class, 'settings'])->add(AuthRequiredMiddleware::class);

    $app->get('/editUser', [SettingsController::class, 'editUserView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editUser', [SettingsController::class, 'updateUser'])->add(AuthRequiredMiddleware::class);
    $app->get('/changePassword', [SettingsController::class, 'changePasswordView'])->add(AuthRequiredMiddleware::class);
    $app->post('/changePassword', [SettingsController::class, 'updatePassword'])->add(AuthRequiredMiddleware::class);
    $app->get('/AfterPassChangeInfo', [SettingsController::class, 'infoAfterPassChange'])->add(AuthRequiredMiddleware::class);
    $app->get('/AfterUserChangeInfo', [SettingsController::class, 'infoAfterUserChange'])->add(AuthRequiredMiddleware::class);
    $app->get('/deleteUser', [SettingsController::class, 'confirmView'])->add(AuthRequiredMiddleware::class);
    $app->get('/dropUser', [SettingsController::class, 'deleteUserData'])->add(AuthRequiredMiddleware::class);

    $app->get('/{type:balanceAll|balanceCategory}/{period:current-month|last-month|current-year}', [BalanceController::class, 'show'])->add(AuthRequiredMiddleware::class);
    $app->get('/{type:balanceAll|balanceCategory}/{period:custom}', [BalanceController::class, 'custom'])->add(AuthRequiredMiddleware::class);
    $app->post('/{type:balanceAll|balanceCategory}/{period:custom}', [BalanceController::class, 'custom'])->add(AuthRequiredMiddleware::class);

    $app->get('/addTransaction/{type:expense|income}', [TransactionController::class, 'addTransactionView'])->add(AuthRequiredMiddleware::class);
    $app->post('/addTransaction/{type:expense|income}', [TransactionController::class, 'handleTransactionAdd'])->add(AuthRequiredMiddleware::class);    

    $app->get("/categories/list/{type:{$categoryTypes}}", [SettingsController::class, 'categoryListView'])->add(AuthRequiredMiddleware::class);
    $app->get("/categories/form/{type:{$categoryTypes}}/{id:\d*}?", [SettingsController::class, 'categoryFormView'])->add(AuthRequiredMiddleware::class);
    $app->post("/categories/save/{type:{$categoryTypes}}/{id:\d*}?", [SettingsController::class, 'handleCategoryForm'])->add(AuthRequiredMiddleware::class);
    $app->post("/categories/delete/{type:{$categoryTypes}}/{id:\d+}", [SettingsController::class, 'handleCategoryDelete'])->add(AuthRequiredMiddleware::class);
}