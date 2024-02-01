<?php

namespace Manger\Controller;

use Manger\Model\User; // fonctionnel
use Manger\Helpers\Session_Helper; // fonctionnel
use Manger\View\UserView;

class Users
{

    private $userModel;

    public function __construct()
    {

        $this->userModel = new User();
    }



    public function GETPage($page)
    {
        require_once VIEWSDIR . DS . 'UserView.php';

        $UserView = new UserView();

        $html = $UserView->view_page($page);

        echo $html;
        http_response_code(200);
    }


    public function showAllUsers()
    {
        header('Content-Type: application/json');
        $data = $this->userModel->getAllUsers();

        // Start output buffering
        ob_start();
        // Include the view file, the $data variable will be used there
        require VIEWSDIR . DS . 'components' . DS . 'admin' . DS . 'users-table.php';
        // Store the buffer content into a variable
        $output = ob_get_clean();

        // Return JSON
        if ($data) {
            echo json_encode(['message' => $output]);
            exit;
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">:( No users present in the database!</h3>']);
            exit;
        }
    }



    public function register()
    {
        //Process form
        // Sanitize email
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $fullname = trim($_POST['fullname'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Initialize data
        $data = [
            'fullname' => $fullname,
            'password' => $password,
            'email' => $email
        ];


        //User with the same email already exists
        if ($this->userModel->findUserByEmail($data['email'])) {
            header('Content-Type: application/json');
            //  http_response_code(400); 
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }

        //Passed validation checks
        //Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        //Register User
        header('Content-Type: application/json');
        if ($this->userModel->register($data)) {
            echo json_encode(['success' => true, 'redirect' => 'login.php']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            exit;
        }
    }



    public function login()
    {
        // Sanitize email
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        // Passwords should not be altered too much but trim whitespace
        $password = trim($_POST['password'] ?? '');

        // Initialize data
        $data = [
            'email' => $email,
            'password' => $password
        ];

        if ($this->userModel->findUserByEmail($data['email'])) {
            //User found
            $loggerInUser = $this->userModel->login($data['email'], $data['password']);
            if ($loggerInUser) {
                //$this->createUserSession($loggerInUser);
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Password Incorrect']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user found']);
            exit;
        }
    }
}
