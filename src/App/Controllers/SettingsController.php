<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
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
    
    public function changePasswordView()
    {   

        echo $this->view->render("settings/changePassword.php");
    }

    public function infoView(array $params = [])
    {
    $message = $params['message'] ?? 'Changes saved successfully!';
    $link = $params['link'] ?? './settings';

        echo $this->view->render("settings/displayInfo.php",
        [
            'message'   =>$message,
            'link'      =>$link
        ]);
    }

    public function confirmView()
    {   
        $message = 'Are you sure you want to delete your account <br> and all associated data?';
        $link = './dropUser';

        echo $this->view->render("settings/confirm.php",
        [
            'message'=>$message,
            'link'=>$link
        ]);
    }

    public function infoAfterPassChange()
    {
            $this->infoView(
            [
                'message'   =>"Password changed successfully.",
                'link'      =>"./settings"
            ]
        );
    }

    public function infoAfterUserChange()
    {
            $this->infoView(
            [
                'message'   =>"User data saved.",
                'link'      =>"./settings"
            ]
        );
    }

    private function getUserId(): int
    {
        return (int)$_SESSION['user'];
    }

    private function renderCategoryListView(array $params)
    {   
        $userId = $this->getUserId();
        
        $categories = $this->transactionService->{$params['transactionServiceMethod']}($userId);
        $categoryCount = count($categories);

        echo $this->view->render("settings/categoryList.php", 
        [
            'title'         => $params['title'],
            'addLink'       => $params['addLink'],
            'editBaseLink'  => $params['editBaseLink'],
            'deleteAction'  => $params['deleteAction'],
            'idKey'         => $params['idKey'],
            'nameKey'       => $params['nameKey'],
            'categories'    => $categories,
            'categoryCount' => $categoryCount,

        ]);
    }

    private function renderCategoryFormView(string $resourceName, string $formKey, string $label, array $routeParams = [])
    {
        $userId = $this->getUserId();
        $categoryId = (int)($routeParams['category'] ?? 0);
        
        $title = $categoryId > 0 ? 'Edit selected category' : 'Add new category';
        $categoryValue = '';

        if ($categoryId > 0) {
            
            $metadata = [
                'categoryId'    => $categoryId,
                'table'         => match($resourceName) 
                    {
                        'income'    => 'income_user_category',
                        'expense'   => 'expense_user_category',
                        'payment'   => 'payment_user_method'
                    },
                'idColumn'      => match($resourceName) 
                    {
                        'income'    => 'id_inc_user_cat',
                        'expense'   => 'id_exp_user_cat',
                        'payment'   => 'id_user_pay_met'
                    },
                'nameColumn'    => match($resourceName) 
                    {
                        'income'    => 'inc_cat_name',
                        'expense'   => 'exp_cat_name',
                        'payment'   => 'pay_met_name'
                    }
            ];

            $data = $this->settingsService->getCategory($userId, $metadata);
            $categoryValue = $data[$metadata['nameColumn']];
        }

        echo $this->view->render("settings/categoryForm.php", 
            [
                'title'         => $title,
                'formAction'    => $categoryId > 0 
                    ? "../edit" . ucfirst($resourceName) . (str_contains($resourceName, 'pay') ? 'Method' : 'Category') . "/" . $categoryId
                    : "/add" . ucfirst($resourceName) . (str_contains($resourceName, 'pay') ? 'Method' : 'Category'), 
                'fieldName'     => $formKey, 
                'label'         => $label, 
                'categoryValue' => $categoryValue,
                'categoryId'    => $categoryId > 0 ? $categoryId : null,
            ]);
    }

    private function handleCategorySave(string $validationMethod, string $insertMethod, string $updateMethod, string $redirectPath, array $routeParams = [])
    {
        $userId = $this->getUserId();
        $formData = $_POST;
        $categoryId = (int)($routeParams['category'] ?? 0); 

        $this->validatorService->{$validationMethod}($formData);
        
        if ($categoryId > 0) {
             $this->settingsService->{$updateMethod}($formData, $categoryId, $userId); 
        } else {
            $this->settingsService->{$insertMethod}($formData, $userId);
        }

        redirectTo($redirectPath);
    }

    private function handleCategoryDelete(string $isUsedMethod, string $deleteMethod, string $redirectPath)
    {
        $userId = $this->getUserId();
        $categoryId = (int)$_POST['id_cat'];
        
        $this->settingsService->{$isUsedMethod}($categoryId, $userId);
        $this->settingsService->{$deleteMethod}($userId, $categoryId);
        
        redirectTo($redirectPath);
    }

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }
    //Income settings
    public function listIncomeView()
    {   
        $params = [
            'title'                     => 'Income categories', 
            'addLink'                   => './addIncomeCategory', 
            'editBaseLink'              => './editIncomeCategory/', 
            'deleteAction'              => '/deleteIncomeCategory',
            'idKey'                     => 'id_inc_user_cat', 
            'nameKey'                   => 'inc_cat_name', 
            'transactionServiceMethod'  => 'getUserIncomeCategory'
        ];
        $this->renderCategoryListView($params);
    }

    public function addIncomeView()
    {   
        $this->renderCategoryFormView('income', 'incomeCategory', 'Income category name');
    }

    public function addIncomeCategory() 
    {
        $this->handleCategorySave('validateIncomeCategory', 'insertIncomeCategory', 'updateIncomeCategory', '/listIncomeCategory');
    }
    public function deleteIncomeCategory()
    {
        $this->handleCategoryDelete('isIncomeCategoryUsed', 'deleteIncomeCategory', '/listIncomeCategory');
    }
    public function editIncomeView(array $id_cat)
    {   
        $this->renderCategoryFormView('income', 'incomeCategory', 'Edit income category', $id_cat);
    }
    public function editIncomeCategory(array $category)
    {
        $this->handleCategorySave('validateIncomeCategory', 'insertIncomeCategory', 'updateIncomeCategory', '../listIncomeCategory', $category);
    }
     //Expense settings
    public function listExpenseView()
    {   
        $params = [
            'title'                     => 'Expense categories', 
            'addLink'                   => './addExpenseCategory', 
            'editBaseLink'              => './editExpenseCategory/', 
            'deleteAction'              => '/deleteExpenseCategory',
            'idKey'                     => 'id_exp_user_cat', 
            'nameKey'                   => 'exp_cat_name', 
            'transactionServiceMethod'  => 'getUserExpenseCategory'
        ];
        $this->renderCategoryListView($params);
    }

    public function addExpenseView()
    {   
        $this->renderCategoryFormView('expense', 'expenseCategory', 'Expense category name');
    }

    public function addExpenseCategory() 
    {
        $this->handleCategorySave('validateExpenseCategory', 'insertExpenseCategory', 'updateExpenseCategory', '/listExpenseCategory');
    }

    public function deleteExpenseCategory()
    {
        $this->handleCategoryDelete('isExpenseCategoryUsed', 'deleteExpenseCategory', '/listExpenseCategory');
    }

    public function editExpenseView(array $id_cat)
    {   
        $this->renderCategoryFormView('expense', 'expenseCategory', 'Edit expense category', $id_cat);
    }

    public function editExpenseCategory(array $category)
    {
        $this->handleCategorySave('validateExpenseCategory', 'insertExpenseCategory', 'updateExpenseCategory', '../listExpenseCategory', $category);
    }
     //Expense settings
    public function listPaymentView()
    {   
        $metadata = [
            'title'                     => 'Payment methods', 
            'addLink'                   => './addPaymentMethod', 
            'editBaseLink'              => './editPaymentMethod/', 
            'deleteAction'              => '/deletePaymentMethod',
            'idKey'                     => 'id_user_pay_met', 
            'nameKey'                   => 'pay_met_name', 
            'transactionServiceMethod'  => 'getUserPaymentMethod'
        ];
        $this->renderCategoryListView($metadata);
    }

    public function addPaymentView()
    {   
        $this->renderCategoryFormView('payment', 'paymentMethod', 'Payment method name');
    }

    public function addPaymentMethod() 
    {
        $this->handleCategorySave('validatePaymentMethod', 'insertPaymentMethod', 'updatePaymentMethod', '/listPaymentMethod');
    }

    public function deletePaymentMethod()
    {
        $this->handleCategoryDelete('isPaymentMethodUsed', 'deletePaymentMethod', '/listPaymentMethod');
    }

    public function editPaymentView(array $id_cat)
    {   
        $this->renderCategoryFormView('payment', 'paymentMethod', 'Edit payment method', $id_cat);
    }

    public function editPaymentMethod(array $category)
    {
        $this->handleCategorySave('validatePaymentMethod', 'insertPaymentMethod', 'updatePaymentMethod', '../listPaymentMethod', $category);
    }
     //User settings
    public function editUserView()
    {   
        $params = $this->settingsService->getUserData($this->getUserId());

        echo $this->view->render("settings/editUser.php", 
        [
            'firstname'     => $params['user_firstname'],
            'lastname'      => $params['user_lastname'],
            'email'         => $params['user_email']
        ]);
    }

    public function updateUser()
    {
        $userId = $this->getUserId();
        $this->validatorService->validateUserData($_POST);
        $this->settingsService->isEmailUsed($_POST['email'], $userId); 
        $this->settingsService->updateUser($_POST, $userId); 

        redirectTo('/AfterUserChangeInfo');
    }

    public function updatePassword()
    {
        $userId = $this->getUserId();
        $this->validatorService->validateUserPassword($_POST);
        $this->settingsService->updatePassword($_POST, $userId);
        redirectTo('/AfterPassChangeInfo');
    }

    public function deleteUserData()
    {
        $userId = $this->getUserId();
        $this->settingsService->deleteUserTransactions($userId);
        $this->settingsService->deleteUserCategories($userId);
        $this->settingsService->deleteCurrentUser($userId);
        $this->userService->logout();
        
        $this->infoView(
            [
                'message'   =>"All your data has been permanently deleted.",
                'link'      =>"./"
            ]
        );
    }
}
