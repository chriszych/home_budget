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
            'redirect_list'     => '/categories/list/income',
        ],
        'expense' => [
            'db_table'          => 'expense_user_category',
            'db_name_col'       => 'exp_cat_name',
            'db_id_col'         => 'id_exp_user_cat',
            'tx_table'          => 'expense',
            'tx_fk_col'         => 'id_exp_cat',
            'redirect_list'     => '/categories/list/expense',
        ],
        'paymentMethod' => [
            'db_table'          => 'payment_user_method',
            'db_name_col'       => 'pay_met_name',
            'db_id_col'         => 'id_user_pay_met',
            'tx_table'          => 'expense',
            'tx_fk_col'         => 'id_pay_met',
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

    public function settings()
    {   
        echo $this->view->render("settings.php");
    }

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

        $listMethod = match($type) {
        'paymentMethod' => 'listUserPaymentMethods',
        default => 'listUser' . ucfirst($type) . 'Categories'
    };
    
    $categories = $this->settingsService->{$listMethod}($userId);

    $title = match($type) {
        'income' => 'Income Categories',
        'expense' => 'Expense Categories',
        'paymentMethod' => 'Payment Methods'
    };

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

    $type = $params['type'];
    $categoryId = isset($params['id']) ? (int)$params['id'] : null;
    $map = $this->getCategoryMap($type);
    $userId = $this->getUserId();

    if (!$map) {
        redirectTo('./settings');
    }

    $categoryValue = '';

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
    
    $title = $categoryId ? 'Edit Category' : 'Add New Category';

    $label = match($type) {
        'income' => 'Income category name',
        'expense' => 'Expense category name',
        'paymentMethod' => 'Payment method name'
    };

    echo $this->view->render('settings/categoryForm.php', [
        'title'         => $title,
        'type'          => $type,
        'categoryId'    => $categoryId,
        'categoryValue' => $categoryValue,
        'label'         => $label,
        'map'           => $map
    ]);
    }

    public function handleCategoryForm(array $params)
    {

    $type = $params['type'];
    $map = $this->getCategoryMap($type);
    $userId = $this->getUserId();
    $categoryId = $params['id'] ?? null;
    $isUpdate = !empty($params['id']); 

    $this->validatorService->validateCategoryName($_POST);

    $this->settingsService->isCategoryTakenGeneric($_POST, $userId, (int)$categoryId, $map);

    if ($isUpdate) {
        $this->settingsService->updateCategoryGeneric($_POST, (int)$categoryId, $map);

    } else {
        $this->settingsService->insertCategoryGeneric($_POST, $userId, $map);
    }

    redirectTo($map['redirect_list']);
    }

    public function handleCategoryDelete(array $params)
    {
    $type = $params['type'];
    $categoryId = $params['id'];
    $map = $this->getCategoryMap($type);

    $this->settingsService->isCategoryUsedGeneric((int)$categoryId, $map);

    $this->settingsService->deleteCategoryGeneric((int)$categoryId, $map);

    redirectTo($map['redirect_list']);

    }

}
