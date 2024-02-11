<?php

namespace Manger;

use Manger\Controller\RecipesController;
use Manger\Controller\Users;
use Manger\Controller\AdminController;
use Manger\Controller\ResetPasswords;


class Router
{
    private $userController;
    private $adminController;

    private $resetPasswordController;
    private $recipesController;

    public function __construct()
    {
        $this->userController = new Users();
        $this->adminController = new AdminController();

        $this->resetPasswordController = new ResetPasswords();
        $this->recipesController = new RecipesController();
    }


    /**
     * Handles incoming HTTP requests and routes to appropriate controllers.
     *
     * This function is the main function of the project's router, adhering to
     * the MVC (Model-View-Controller) architecture. It analyzes the URL of the request,
     * determines the controller to use based on URL segments, and then calls
     * appropriate controller methods based on the request method (GET or POST) and
     * request parameters.
     *
     * @return void
     */
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
                    $this->userController->updateUserDetails();
                    break;
                case 'update-user-credentials':
                    $this->userController->updateUserCredentials();
                    break;
                case 'first-login':
                    $this->userController->updateUserFirstLogin();
                    break;
                case 'showAllRecipes':
                    $this->recipesController->recipesCont();
                    break;
                case 'addRecipe':
                    $this->recipesController->addNewRecipe();
                    break;
                case 'showAllUsers':
                    $this->adminController->showAllUsers();
                    break;

                case 'logout':
                    $this->userController->logout();
                    break;
                default:
                    include __DIR__ . '/../Views/login.php';
                    exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {


            // Check if the session exists, and redirect if necessary
            if (!isset($_SESSION['id']) && !in_array($requested, $no_redirect_pages)) {
                $this->userController->GETPage("login");
                exit();
            }

            // Check for specific actions in the GET request
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'countRegularUsers':
                        // Assuming you have an adminController or similar for handling admin-related actions
                        $this->adminController->countRegularUsers();
                        break;
                    case 'countNutritionistUsers':
                        $this->adminController->countNutritionistUsers();
                        break;
                        // Add other GET actions here
                    default:
                        // If no specific action, fallback to generic page handling
                        $this->userController->GETPage($requested);
                        break;
                }
            } else {
                // No action specified, handle as a page request
                $this->userController->GETPage($requested);
            }
        }
    }
}
