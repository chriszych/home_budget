<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService 
{
    public function __construct(private Database $db)
    {
        
    }

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE user_email = :email",
            [
                'email' => $email
            ]
        )->count();

        if ($emailCount > 0)
        
        {
            throw new ValidationException(['email' => ['Adres e-mail już użyty!']]);
        }
    }

    public function create(array $formData) 
    {
        
        $password = password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $date = date('Y-m-d');

        $this->db->query(

            "INSERT INTO users(user_firstname, user_lastname, user_email, user_password, user_reg_date) 
            VALUES (:firstname, :lastname, :email, :password, :date)",
            [
                'firstname' => $formData['firstname'],
                'lastname' => $formData['lastname'],
                'email' => $formData['email'], 
                'password' => $password,
                'date' => $date
            ]
        );

        $newUserId = $this->db->query(
            "SELECT id_user 
            FROM users 
            WHERE user_email = :email",
            [
                'email' => $formData['email']
                ]
        )->find();


         $this->db->query(
            "INSERT INTO expense_user_category (exp_cat_name, id_user) 
            SELECT exp_cat_name, :user_id 
            FROM default_expense_category", 
            [
                'user_id' => $newUserId['id_user']
            ]
        );
        
         $this->db->query(
            "INSERT INTO income_user_category (inc_cat_name, id_user) 
            SELECT inc_cat_name, :user_id 
            FROM default_income_category", 
            [
                'user_id' => $newUserId['id_user']
            ]
        );
         $this->db->query(
            "INSERT INTO payment_user_method (pay_met_name, id_user) 
            SELECT pay_met_name, :user_id 
            FROM default_payment_method", 
            [
                'user_id' => $newUserId['id_user']
            ]
        );
        
        $_SESSION['welcomeText'] = "Konto utworzone! Możesz już się zalogować:";
    }

    public function login(array $formData) 
    {
        $user = $this->db->query("SELECT * FROM users WHERE user_email = :email", [
            'email' => $formData['email']
        ])->find();


        $passwordMatch = password_verify(
            $formData['password'], 
            $user['user_password'] ?? ''
            );

        if(!$user || !$passwordMatch) {
            throw new ValidationException(['password' => ['Błędne dane logowania']]);
        }

        session_regenerate_id();

        $_SESSION['user'] = $user['id_user'];

    }

    public function logout()
    {
        session_destroy();
        $params = session_get_cookie_params();
        
        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
        //redirectTo('/');
    }

    public function getUserBalance() : array
    {

        $sqlMonthHiLimit = date('Y-m-t 23:59:59');
        $sqlMonthLowLimit = date('Y-m-01 00:00:00');

        $user = $this->db->query("SELECT * FROM users WHERE id_user = :id", [
            'id' => $_SESSION['user'] 
        ])->find();

			
			$today = new \DateTime(date('Y-m-d')); 
			$reg_date = new \DateTime($user['user_reg_date']); 
			$interval = $today->diff($reg_date); 
			$loggedDays = $interval->days;
            $firstname = $user['user_firstname'];
			
			if ($loggedDays == 0){
				$loggedRegDate = "dzisiaj!";
			} else {
				$loggedRegDate = $interval->format('%y lat, %m miesięcy, %d dni');
			}
			

                $total_exp = $this->db->query(
                    "SELECT SUM(exp_amount) AS total_exp FROM expense WHERE expense.id_user=:id AND exp_date BETWEEN :low_limit AND :hi_limit", 
                    [
                        'id' => $_SESSION['user'],
                        'low_limit' => $sqlMonthLowLimit,
                        'hi_limit' => $sqlMonthHiLimit
                    ])->find()['total_exp'];
                
                 $total_inc = $this->db->query(
                    "SELECT SUM(inc_amount) AS total_inc FROM income WHERE income.id_user=:id AND inc_date BETWEEN :low_limit AND :hi_limit", 
                    [
                        'id' => $_SESSION['user'],
                        'low_limit' => $sqlMonthLowLimit,
                        'hi_limit' => $sqlMonthHiLimit
                    ])->find()['total_inc'];

    return  ['total_inc' => $total_inc,
            'total_exp' => $total_exp,
            'loggedDays' => $loggedDays,
            'loggedRegDate' => $loggedRegDate,
            'firstname' => $firstname];
    }
}