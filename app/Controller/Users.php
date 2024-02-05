<?php

namespace Manger\Controller;

use Manger\Model\User;
use Manger\Views\UserView;

/**
 * Controller for User-related things.
 * 
 * Handle actions such as registration, login, logout, and all modifications of attributes.
 */
class Users
{

    /**
     * userModel
     *
     * @var User
     */
    private $userModel;

    /**
     * Constructor
     *
     * Initializes the Users Controller with the User Model.
     */
    public function __construct()
    {

        $this->userModel = new User();
    }


    /**
     * Display page from the View
     *
     * Renders and displays the specified page using the UserView.
     *
     * @param string $page The page to display.
     * @return void
     */
    public function GETPage($page)
    {

        $UserView = new UserView();

        $html = $UserView->view_page($page);

        echo $html;
        http_response_code(200);
    }

    /**
     * Show All Users
     *
     * Retrieves all users from the model and display them through <strong>users-table.php</strong>.
     *
     * @return void
     */
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



    /**
     * Register
     * 
     * Take the parameters from the _POST_ request, sanitize them and check in the database
     * if they correspond to a user.
     * If not, the password is hashed and all the data is sent to the Model to save it in the database.
     *
     * @return void
     */
    public function register()
    {
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

        //Passed validation checks so Hashing password
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



    /**
     * Login
     * 
     * Take the parameters from the _POST_ request, and check in the database if they correspond to a user.
     * If so, a session with the user's parameters is created.
     *
     * @return void
     */
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
            $loggerInUser = $this->userModel->login($data['email'], $data['password']);
            if ($loggerInUser) {
                $this->createUserSession($loggerInUser);
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

    /**
     * Start the session.
     * 
     * Take the parameters of *$user* and put them in the session,
     * attesting that the user is logged in.
     *
     * @param  mixed $user
     * @return void
     */
    public function createUserSession($user)
    {
        $_SESSION['id'] = $user->id;
        $_SESSION['fullname'] = $user->fullname;
        $_SESSION['email'] = $user->email;
        $_SESSION['height'] = $user->height;
        $_SESSION['age'] = $user->age;
        $_SESSION['weight'] = $user->weight;
        $_SESSION['goal'] = $user->goal;
    }

    /**
     * Remove data from the session, then destroy it.
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
        unset($_SESSION['height']);
        unset($_SESSION['age']);
        unset($_SESSION['weight']);
        unset($_SESSION['goal']);

        session_destroy();
        echo json_encode(['success' => true]);
        exit;
    }

    /**
     * Update User Details
     *
     * Updates user details after sainitizing them,
     * then create a new session for the user.
     *
     * @return void
     */
    public function update_user_details()
    {

        $id = filter_var(trim($_POST['user_id'] ?? ''), FILTER_SANITIZE_NUMBER_INT);
        $fullname = filter_var(trim($_SESSION['fullname'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $goal = filter_var(trim($_POST['goal'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $height = filter_var(trim($_POST['height'] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $weight = filter_var(trim($_POST['weight'] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $age = filter_var(trim($_POST['age'] ?? ''), FILTER_SANITIZE_NUMBER_INT);

        //Init data
        $data = [
            'id' => $id,
            'fullname' => $fullname,
            'goal' => $goal,
            'height' => $height,
            'weight' => $weight,
            'age' => $age
        ];

        if ($this->userModel->update_user_details($data)) {
            $updatedUser = $this->userModel->getUserById($data['id']);
            $this->createUserSession($updatedUser);
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'No user found']);
            exit;
        }
    }


    /**
     * Update credentials.
     * 
     * Update important credentials in the database after sanitizing them,
     * then create a new session for the user.
     *
     * @return void
     */
    public function update_user_credentials()
    {


        //Init data
        $data = [
            'id' => $_SESSION['id'],
            'email' => trim($_POST['email'], FILTER_SANITIZE_EMAIL),
            'old_password' => trim($_POST['old_password']),
            'new_password' => trim($_POST['new_password']),
        ];

        if ($this->userModel->update_user_credentials($data)) {
            $updatedUser = $this->userModel->getUserById($data['id']);
            $this->createUserSession($updatedUser);
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Old password incorrect']);
            exit;
        }
    }

    /**
     * Update User First Login
     *
     * Updates user details in the database via the Model function during the first login.
     *
     * @return void
     */
    public function update_user_first_login()
    {
        // Sanitize each POST field individually
        $id = filter_var(trim($_POST['id'] ?? ''), FILTER_SANITIZE_NUMBER_INT);
        $fullname = filter_var(trim($_SESSION['fullname'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $goal = filter_var(trim($_POST['goal'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $height = filter_var(trim($_POST['height'] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $weight = filter_var(trim($_POST['weight'] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $age = filter_var(trim($_POST['age'] ?? ''), FILTER_SANITIZE_NUMBER_INT);
        $gender = filter_var(trim($_POST['gender'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dailyCalories = filter_var(trim($_POST['dailyCalories'] ?? ''), FILTER_SANITIZE_NUMBER_INT);

        // Initialize data
        $data = [
            'id' => $id,
            'fullname' => $fullname,
            'goal' => $goal,
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'gender' => $gender,
            'dailyCalories' => $dailyCalories
        ];


        if ($this->userModel->update_user_first_login($data)) {
            $updatedUser = $this->userModel->getUserById($data['id']);
            $this->createUserSession($updatedUser);
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
            exit;
        }
    }
}
