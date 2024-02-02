<?php

namespace Manger;

use Manger\Controller\Users;
use Manger\Controller\ResetPasswords;


class Router
{
    private $userController;
    private $resetPasswordController;

    public function __construct()
    {
        $this->userController = new Users();
        $this->resetPasswordController = new ResetPasswords();
    }


    public function manageRequest()
    {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uriSegments = explode('/', $path);

        $requested = $uriSegments[2];
        $controller = "user";

        if ($requested === 'admin' || $requested === 'nutritionist') {
            $controller = $requested;
            $requested = $uriSegments[3];
        }

        $requested = $requested !== "" ? $requested : "login";
        $no_redirect_pages = array('login', 'register', 'reset-password');


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            switch ($_POST['action']) {
                case 'register':
                    $this->userController->register();
                    break;
                case 'login':
                    $this->userController->login();
                    break;
                case 'resetPassword':
                    $this->resetPasswordController->sendEmail();
                    break;
                case 'newPassword':
                    $this->resetPasswordController->resetPassword();
                    break;
                case 'update-user-details':
                    $this->userController->update_user_details();
                    break;
                case 'update-user-credentials':
                    $this->userController->update_user_credentials();
                    break;
                case 'first-login':
                    $this->userController->update_user_first_login();
                    break;
                case 'showAllUsers':
                    $this->userController->showAllUsers();
                    break;
                default:
                    include __DIR__ . '/../Views/login.php';
                    exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {


            if (!isset($_SESSION['id']) && !in_array($requested, $no_redirect_pages)) {
                $this->userController->GETPage("login");
                exit();
            }
            $this->userController->GETPage($requested);
        }
    }
}
