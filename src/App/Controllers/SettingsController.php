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
    
    private function getCategoryMap(string $type): ?array
{
    $map = [
        'income' => [
            'db_table'          => 'income_user_category',
            'db_name_col'       => 'inc_cat_name',
            'db_id_col'         => 'id_inc_user_cat',
            'tx_table'          => 'income',
            'tx_fk_col'         => 'id_inc_cat',
            //'category_type'     => 'przychodu', //eng?
            'redirect_list'     => '/categories/list/income',
        ],
        'expense' => [
            'db_table'          => 'expense_user_category',
            'db_name_col'       => 'exp_cat_name',
            'db_id_col'         => 'id_exp_user_cat',
            'tx_table'          => 'expense',
            'tx_fk_col'         => 'id_exp_cat',
           // 'category_type'     => 'wydatku', //eng?
            'redirect_list'     => '/categories/list/expense',
        ],
        'paymentMethod' => [
            'db_table'          => 'payment_user_method',
            'db_name_col'       => 'pay_met_name',
            'db_id_col'         => 'id_user_pay_met',
            'tx_table'          => 'expense',
            'tx_fk_col'         => 'id_pay_met',
           // 'category_type'     => 'metody płatności', //eng?
            'redirect_list'     => '/categories/list/paymentMethod',
        ],
    ];
    return $map[$type] ?? null;
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

    public function confirmView(array $params = [])
    {   
        $message = $params['message'] ?? 'Are you sure you want to delete your account <br> and all associated data?';
        $link = $params['link'] ??'./dropUser';

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

    // private function handleCategoryDelete(string $isUsedMethod, string $deleteMethod, string $redirectPath)
    // {
    //     $userId = $this->getUserId();
    //     $categoryId = (int)$_POST['id_cat'];
        
    //     $this->settingsService->{$isUsedMethod}($categoryId, $userId);
    //     $this->settingsService->{$deleteMethod}($userId, $categoryId);
        
    //     redirectTo($redirectPath);
    // }

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }
    //Income settings
    // public function listIncomeView()
    // {   
    //     $params = [
    //         'title'                     => 'Income categories', 
    //         'addLink'                   => './addIncomeCategory', 
    //         'editBaseLink'              => './editIncomeCategory/', 
    //         'deleteAction'              => '/deleteIncomeCategory',
    //         'idKey'                     => 'id_inc_user_cat', 
    //         'nameKey'                   => 'inc_cat_name', 
    //         'transactionServiceMethod'  => 'getUserIncomeCategory'
    //     ];
    //     $this->renderCategoryListView($params);
    // }

    // public function addIncomeView()
    // {   
    //     $this->renderCategoryFormView('income', 'incomeCategory', 'Income category name');
    // }

    // public function addIncomeCategory() 
    // {
    //     $this->handleCategorySave('validateIncomeCategory', 'insertIncomeCategory', 'updateIncomeCategory', '/listIncomeCategory');
    // }
    // public function deleteIncomeCategory()
    // {
    //     $this->handleCategoryDelete('isIncomeCategoryUsed', 'deleteIncomeCategory', '/listIncomeCategory');
    // }
    // public function editIncomeView(array $id_cat)
    // {   
    //     $this->renderCategoryFormView('income', 'incomeCategory', 'Edit income category', $id_cat);
    // }
    // public function editIncomeCategory(array $category)
    // {
    //     $this->handleCategorySave('validateIncomeCategory', 'insertIncomeCategory', 'updateIncomeCategory', '../listIncomeCategory', $category);
    // }
    //  //Expense settings
    // public function listExpenseView()
    // {   
    //     $params = [
    //         'title'                     => 'Expense categories', 
    //         'addLink'                   => './addExpenseCategory', 
    //         'editBaseLink'              => './editExpenseCategory/', 
    //         'deleteAction'              => '/deleteExpenseCategory',
    //         'idKey'                     => 'id_exp_user_cat', 
    //         'nameKey'                   => 'exp_cat_name', 
    //         'transactionServiceMethod'  => 'getUserExpenseCategory'
    //     ];
    //     $this->renderCategoryListView($params);
    // }

    // public function addExpenseView()
    // {   
    //     $this->renderCategoryFormView('expense', 'expenseCategory', 'Expense category name');
    // }

    // public function addExpenseCategory() 
    // {
    //     $this->handleCategorySave('validateExpenseCategory', 'insertExpenseCategory', 'updateExpenseCategory', '/listExpenseCategory');
    // }

    // public function deleteExpenseCategory()
    // {
    //     $this->handleCategoryDelete('isExpenseCategoryUsed', 'deleteExpenseCategory', '/listExpenseCategory');
    // }

    // public function editExpenseView(array $id_cat)
    // {   
    //     $this->renderCategoryFormView('expense', 'expenseCategory', 'Edit expense category', $id_cat);
    // }

    // public function editExpenseCategory(array $category)
    // {
    //     $this->handleCategorySave('validateExpenseCategory', 'insertExpenseCategory', 'updateExpenseCategory', '../listExpenseCategory', $category);
    // }
    //  //Expense settings
    // public function listPaymentView()
    // {   
    //     $metadata = [
    //         'title'                     => 'Payment methods', 
    //         'addLink'                   => './addPaymentMethod', 
    //         'editBaseLink'              => './editPaymentMethod/', 
    //         'deleteAction'              => '/deletePaymentMethod',
    //         'idKey'                     => 'id_user_pay_met', 
    //         'nameKey'                   => 'pay_met_name', 
    //         'transactionServiceMethod'  => 'getUserPaymentMethod'
    //     ];
    //     $this->renderCategoryListView($metadata);
    // }

    // public function addPaymentView()
    // {   
    //     $this->renderCategoryFormView('payment', 'paymentMethod', 'Payment method name');
    // }

    // public function addPaymentMethod() 
    // {
    //     $this->handleCategorySave('validatePaymentMethod', 'insertPaymentMethod', 'updatePaymentMethod', '/listPaymentMethod');
    // }

    // public function deletePaymentMethod()
    // {
    //     $this->handleCategoryDelete('isPaymentMethodUsed', 'deletePaymentMethod', '/listPaymentMethod');
    // }

    // public function editPaymentView(array $id_cat)
    // {   
    //     $this->renderCategoryFormView('payment', 'paymentMethod', 'Edit payment method', $id_cat);
    // }

    // public function editPaymentMethod(array $category)
    // {
    //     $this->handleCategorySave('validatePaymentMethod', 'insertPaymentMethod', 'updatePaymentMethod', '../listPaymentMethod', $category);
    // }
    //  //User settings
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

    public function categoryListView(array $params)
    {
        $type = $params['type'];
        $map = $this->getCategoryMap($type);
        $userId = $this->getUserId();

        if (!$map) {
            redirectTo('/settings');
        }

        //dd($map['view_list']);
        //$listMethod = "getUserCategories" . ucfirst($type);
        //$listData = $this->transactionService->{$listMethod}($userId);
        // $listMethod = "listUser" . ucfirst($type) . "Categories";
        // $listData = $this->settingsService->{$listMethod}($userId);
        //dd($listData); // array -> user categries
        //dd($params); // [type] => income
        // dd($map); // db data
        // echo $this->view->render('/settings/categoryList.php', $listData);
        //echo $this->view->render($map['view_list'], $listData);
        $listMethod = match($type) {
        'paymentMethod' => 'listUserPaymentMethods',
        default => 'listUser' . ucfirst($type) . 'Categories'
    };
    
    // Pobranie listy kategorii.
    $categories = $this->settingsService->{$listMethod}($userId);

    // Dynamiczne tworzenie tytułu strony na podstawie typu kategorii.
    $title = match($type) {
        'income' => 'Income Categories',
        'expense' => 'Expense Categories',
        'paymentMethod' => 'Payment Methods'
    };

    // Przekazanie do widoku pełnej tablicy z wymaganymi danymi.
    echo $this->view->render('settings/categoryList.php', [
        'title'         => $title,
        'type'          => $type,
        'categories'    => $categories,
        'categoryCount' => count($categories),
        'idKey'         => $map['db_id_col'],
        'nameKey'       => $map['db_name_col']
    ]);
    }

    public function categoryFormView(array $params)
    {
    // $type = $params['type'];
    // $categoryId = $params['id'] ?? null;
    // $map = $this->getCategoryMap($type);
    
    // echo $this->view->render('settings/categoryForm.php', [
    //     'map' => $map,
    // ]);
    $type = $params['type'];
    $categoryId = isset($params['id']) ? (int)$params['id'] : null;
    $map = $this->getCategoryMap($type);
    $userId = $this->getUserId();

    if (!$map) {
        redirectTo('/settings');
    }

    $categoryValue = '';
    // Jeśli edytujemy, pobierz nazwę istniejącej kategorii
    if ($categoryId) {
        $metadata = [
            'categoryId' => $categoryId,
            'table'      => $map['db_table'],
            'idColumn'   => $map['db_id_col'],
            'nameColumn' => $map['db_name_col']
        ];
        $data = $this->settingsService->getCategory($userId, $metadata);
        if ($data) {
            $categoryValue = $data[$map['db_name_col']];
        }
    }
    
    // Ustaw tytuł w zależności od tego, czy dodajemy, czy edytujemy
    $title = $categoryId ? 'Edit Category' : 'Add New Category';

    $label = match($type) {
        'income' => 'Income category name',
        'expense' => 'Expense category name',
        'paymentMethod' => 'Payment method name'
    };

    // Przekaż wszystkie potrzebne dane do widoku
    echo $this->view->render('settings/categoryForm.php', [
    //dd([
        'title'         => $title,
        'type'          => $type,
        'categoryId'    => $categoryId,
        'categoryValue' => $categoryValue,
        'label'         => $label,
        'map'           => $map // mapa może być przydatna do budowania URL w widoku
    ]);
    }

    public function handleCategoryForm(array $params)
    {
     // dd($params);  
    $type = $params['type'];
    $map = $this->getCategoryMap($type);
    $userId = $this->getUserId();
    //$categoryId = $params['id'] ?? null;
    $categoryId = $params['id'] ?? null;
    //$isUpdate = !empty($params['id']); 
    $isUpdate = !empty($params['id']); 

   // dd($params);

    //$this->validatorService->{$map['service_validate']}($_POST);
    $this->validatorService->validateCategoryName($_POST);

    //$this->settingsService->{$map['service_is_taken']}($_POST, $userId, $params['id'] ?? null);
    $this->settingsService->isCategoryTakenGeneric($_POST, $userId, (int)$categoryId, $map);

    // $method = $isUpdate ? $map['service_update'] : $map['service_insert'];
    // $this->settingsService->{$method}($_POST, $userId, $params['id'] ?? null); 
    if ($isUpdate) {
        $this->settingsService->updateCategoryGeneric($_POST, (int)$categoryId, $map);
        //$message = 'Kategoria zaktualizowana pomyślnie!';
    } else {
        $this->settingsService->insertCategoryGeneric($_POST, $userId, $map);
        //$message = 'Kategoria dodana pomyślnie!';
    }

    // $this->infoView([
    //     'message' => 'Saved sucessfully!',
    //     'link'    => $map['redirect_list']
    //     ]);
    redirectTo($map['redirect_list']);
    }

    public function handleCategoryDelete(array $params)
    {
    $type = $params['type'];
    $categoryId = $params['id'];
    $map = $this->getCategoryMap($type);
    //$userId = $this->getUserId();

   //$this->settingsService->{$map['service_is_used']}($categoryId, $map);
   $this->settingsService->isCategoryUsedGeneric((int)$categoryId, $map);
 
    //$this->settingsService->deleteCategoryGeneric($categoryId, $map['db_table'], $map['db_id_col']);
    $this->settingsService->deleteCategoryGeneric((int)$categoryId, $map);

    $this->confirmView([
        'message' => 'Are you sure to delete this category?',
        'link'    => $map['redirect_list']
    ]);
    redirectTo($map['redirect_list']);
    }

}
