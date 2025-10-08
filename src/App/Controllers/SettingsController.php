<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{
    SettingsService, 
    TransactionService,
    ValidatorService,
    UserService
    };


class SettingsController
{
    
    public function __construct(
        private TemplateEngine $view,
        private SettingsService $settingsService,
        private ValidatorService $validatorService,
        private TransactionService $transactionService,
        private UserService $userService
        )
    {

    }    

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }

    public function listIncomeView()
    {   
        $params = $this->transactionService->getUserIncomeCategory((int)$_SESSION['user']);  

        echo $this->view->render("settings/listIncomeCategory.php", $params);
    }

    public function addIncomeView()
    {   

        echo $this->view->render("settings/addIncomeCategory.php");
    }

    public function addIncomeCategory() 
    {
        $this->validatorService->validateIncomeCategory($_POST);
        $this->settingsService->isIncomeCategoryTaken($_POST);
        $this->settingsService->insertIncomeCategory($_POST);

        redirectTo('/listIncomeCategory');
    }

    public function deleteIncomeCategory()
    {
        $this->settingsService->isIncomeCategoryUsed((int)$_POST['id_cat']);
        $this->settingsService->deleteIncomeCategory($_POST);
    }

    public function editIncomeView(array $id_cat)
    {   
        $params = $this->settingsService->getUserIncomeCategory($id_cat['category']);

        echo $this->view->render("settings/editIncomeCategory.php", [
            'category' => $params['inc_cat_name'],
            'id_cat' => $id_cat['category']
        ]);
    }

    public function editIncomeCategory(array $category)
    {

        $this->validatorService->validateIncomeCategory($_POST);
        $this->settingsService->isIncomeCategoryTaken($_POST);
        $this->settingsService->updateIncomeCategory($_POST, (int)$category['category']);

        redirectTo('../listIncomeCategory');
    }

    public function addExpenseView()
    {   

        echo $this->view->render("settings/addExpenseCategory.php");
    }

    public function addExpenseCategory() 
    {
        $this->validatorService->validateExpenseCategory($_POST);
        $this->settingsService->isExpenseCategoryTaken($_POST);
        $this->settingsService->insertExpenseCategory($_POST);

        redirectTo('/listExpenseCategory');
    }

    public function listExpenseView()
    {   
        $params = $this->transactionService->getUserExpenseCategory((int)$_SESSION['user']);  

        echo $this->view->render("settings/listExpenseCategory.php", $params);
    }

    public function deleteExpenseCategory()
    {
        $this->settingsService->isExpenseCategoryUsed((int)$_POST['id_cat']);
        $this->settingsService->deleteExpenseCategory($_POST);
    }
    
    public function editExpenseView(array $id_cat)
    {   
        $params = $this->settingsService->getUserExpenseCategory($id_cat['category']);

        echo $this->view->render("settings/editExpenseCategory.php", [
            'category' => $params['exp_cat_name'],
            'id_cat' => $id_cat['category']
        ]);
    }

    public function editExpenseCategory(array $category)
    {

        $this->validatorService->validateExpenseCategory($_POST);
        $this->settingsService->isExpenseCategoryTaken($_POST);
        $this->settingsService->updateExpenseCategory($_POST, (int)$category['category']);

        redirectTo('../listExpenseCategory');
    }

    public function listPaymentView()
    {   
        $params = $this->transactionService->getUserPaymentMethod((int)$_SESSION['user']);  

        echo $this->view->render("settings/listPaymentMethod.php", $params);
    }

    public function editPaymentView(array $id_cat)
    {   
        $params = $this->settingsService->getUserPaymentMethod($id_cat['category']);

        echo $this->view->render("settings/editPaymentMethod.php", [
            'category' => $params['pay_met_name'],
            'id_cat' => $id_cat['category']
        ]);
    }

    public function editPaymentMethod(array $category)
    {

        $this->validatorService->validatePaymentMethod($_POST);
        $this->settingsService->isPaymentMethodTaken($_POST);
        $this->settingsService->updatePaymentMethod($_POST, (int)$category['category']);

        redirectTo('../listPaymentMethod');
    }

    public function addPaymentView()
    {   

        echo $this->view->render("settings/addPaymentMethod.php");
    }

    public function addPaymentMethod() 
    {
        $this->validatorService->validatePaymentMethod($_POST);
        $this->settingsService->isPaymentMethodTaken($_POST);
        $this->settingsService->insertPaymentMethod($_POST);

        redirectTo('/listPaymentMethod');
    }

    public function deletePaymentMethod()
    {
        $this->settingsService->isPaymentMethodUsed((int)$_POST['id_cat']);
        $this->settingsService->deletePaymentMethod($_POST);
    }

    public function editUserView()
    {   
        $params = $this->settingsService->getUserData();

        echo $this->view->render("settings/editUser.php", 
        [
            'firstname' => $params['user_firstname'],
            'lastname' => $params['user_lastname'],
            'email' => $params['user_email']
        ]);
    }

    public function updateUser()
    {
        $this->validatorService->validateUserData($_POST);
        $this->settingsService->isEmailUsed($_POST['email']);
        $this->settingsService->updateUser($_POST);

        redirectTo('/displayInfo');
    }
    
    public function changePasswordView()
    {   

        echo $this->view->render("settings/changePassword.php");
    }

    public function updatePassword()
    {
        $this->validatorService->validateUserPassword($_POST);
        $this->settingsService->updatePassword($_POST);
        redirectTo('/displayInfo');
    }

    public function infoView()
    {   
        $message = 'Zmiany zapisane pomyślnie!';
        $link = './settings';

        echo $this->view->render("settings/displayInfo.php",
        [
            'message'=>$message,
            'link'=>$link
        ]);
    }

    public function confirmView()
    {   
        $message = 'Czy na pewno chcesz usunać użytkownika <br> i wszystkie jego dane?';
        $link = './settings';

        echo $this->view->render("settings/confirm.php",
        [
            'message'=>$message,
            'link'=>$link
        ]);
    }


}
