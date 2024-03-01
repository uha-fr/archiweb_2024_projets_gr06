<?php

namespace Manger\Controller;

use Manger\Model\AdminModel;
use Manger\Views\UserView;
use Manger\Views\AdminView;
use Manger\Model\User;

use PDOException;

/**
 * Controller for Admin-related things.
 * 
 * Handle actions such as registration, login, logout, and all modifications of attributes.
 */
class AdminController
{

    /**
     * adminModel
     *
     * @var AdminModel
     */
    private $adminModel;
    /**
     * userModel
     *
     * @var UserModel
     */
    private $userModel;
    /**
     * recipeModel
     *
     * @var recipeModel
     */
    private $recipeModel;



    /**
     * Constructor
     *
     * Initializes the Admins Controller with the Admin Model.
     */
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->userModel = new User();

    }


    /**
     * Show All Users
     *
     * Retrieves all users from the model and display them through <strong>users-table.php</strong>.
     *
     * @return void
     */
    public function getAllUsers()
    {
        header('APPJSON');
        $data = $this->adminModel->getAllUsers();

        if ($data) {
            // Output buffering to capture the included file's content
            ob_start();
            include VIEWSDIR . DS . 'components' . DS . 'admin' . DS . 'users-table.php';
            $output = ob_get_clean();

            // Echo the content captured, which now includes $data being used in usersList.php
            echo json_encode(['message' => $output]);
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">:( No users present in the database!</h3>']);
        }
        exit;
    }

    /**
     * Fetch and display user information by ID.
     *
     * Responds to an AJAX request by fetching a user's details based on the provided ID.
     * The user's information is returned as a JSON object for use in the frontend.
     *
     * @return void Outputs the user data in JSON format.
     */
    public function getUserDetails()
    {
        header('APPJSON');
        $userId = isset($_GET['info_id']) ? $_GET['info_id'] : '';

        if (!empty($userId)) {
            $data = $this->adminModel->getUserById($userId);

            if ($data) {
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user ID provided.']);
        }
        exit;
    }

    /**
     * Handles the deletion of a user.
     *
     * This method is called when a request to delete a user is received.
     * It retrieves the user ID from the POST data, calls the model to delete the user,
     * and then returns a JSON response indicating the success or failure of the operation.
     *
     * @return void Outputs a JSON response with the operation result.
     */
    public function deleteUser()
    {
        if (isset($_POST['del_id'])) {
            $del_id = $_POST['del_id'];
            $result = $this->adminModel->deleteUserById($del_id);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
            }
            exit;
        }
    }


    public function getAllRecipes(){
        header('APPJSON');
        $data = $this->adminModel->getAllRecipes();
        if ($data) {
            // Output buffering to capture the included file's content
            ob_start();
            include VIEWSDIR . DS . 'components' . DS . 'admin' . DS . 'recipes-table.php';
            $output = ob_get_clean();

            // Echo the content captured, which now includes $data being used in recipesList.php
            echo json_encode(['message' => $output]);
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">:( No recipes present in the database!</h3>']);
        }
        exit;
    }

    public function getRecipeDetails()
    {
        header('APPJSON');
        $recipeId = isset($_GET['info_id']) ? $_GET['info_id'] : '';

        if (!empty($recipeId)) {
            $data = $this->adminModel->getRecipeById($recipeId);

            if ($data) {
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user ID provided.']);
        }
        exit;
    }

    /**
     * Count Regular Users
     * 
     * Retrieves and returns the count of users with a role of 'regular'.
     *
     * @return void
     */
    public function countRegularUsers()
    {
        try {
            $regularUsersCount = $this->adminModel->getRegularUsersCount();

            // Assuming the count is successfully retrieved, send a JSON response
            echo json_encode(['success' => true, 'count' => $regularUsersCount]);
        } catch (PDOException $e) {
            // If an error occurs, send a JSON response with the error message
            echo json_encode(['success' => false, 'message' => 'An error occurred while fetching the user count.']);
        }
        exit; // Ensure no further script execution
    }
    /**
     * Count Regular Users
     * 
     * Retrieves and returns the count of users with a role of 'regular'.
     *
     * @return void
     */
    public function countNutritionistUsers()
    {
        try {
            $nutritionistCount = $this->adminModel->getNutritionistCount();


            // Assuming the count is successfully retrieved, send a JSON response
            echo json_encode(['success' => true, 'count' => $nutritionistCount]);
        } catch (PDOException $e) {
            // If an error occurs, send a JSON response with the error message
            echo json_encode(['success' => false, 'message' => 'An error occurred while fetching the user count.']);
        }
        exit; // Ensure no further script execution
    }


    /**
     * Count Recipes
     * 
     * Retrieves and returns the count of Recipes.
     *
     * @return void
     */
    public function countRecipes()
    {
        try {
            $recipesCount = $this->adminModel->getRecipesCount();


            // Assuming the count is successfully retrieved, send a JSON response
            echo json_encode(['success' => true, 'count' => $recipesCount]);
        } catch (PDOException $e) {
            // If an error occurs, send a JSON response with the error message
            echo json_encode(['success' => false, 'message' => 'An error occurred while fetching the user count.']);
        }
        exit; // Ensure no further script execution
    }


    /**
 * Add a new user with profile image.
 *
 * Processes the form submission, sanitizes input, handles profile image upload,
 * and add a new user in the database. It checks for an existing user with the same
 * email, handles password hashing, and includes the profile image's filename in the database.
 * Responds with JSON indicating success or failure.
 *
 * @return void Outputs JSON response.
 */
public function addNewUser()
{
    // Check if a file was uploaded and handle the file upload first
    $imageUploadPath = ''; // Default value if no file is uploaded
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageUpload"])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/archiweb_2024_projets_gr06/public/images/profile-images/';
        $fileName = basename($_FILES["imageUpload"]["name"]);
        $targetFilePath = $targetDir . $fileName;
       // var_dump($targetFilePath);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Optional: Validate file size and type here before proceeding with the upload

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFilePath)) {
            $imageUploadPath = '/public/images/profile-images/' . $fileName;
        } else {
            // Handle file upload failure
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'File upload failed']);
            exit; // Stop execution if file upload fails
        }
    }

    // Sanitize input data
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $fullname = trim($_POST['fullname'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Prepare data array for user registration
    $data = [
        'fullname' => $fullname,
        'password' => $password,
        'email' => $email,
        'image' => $imageUploadPath // Use the uploaded image path or default
    ];

    // Check if user with this email already exists
    if ($this->userModel->findUserByEmail($data['email'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        return;
    }

    // Hash password before storing
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // Attempt to register the user
    if ($this->adminModel->addNewUser($data)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'redirect' => 'login.php']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Something went wrong']);
    }
}


public function addNewRecipe()
    {
    // Check if a file was uploaded and handle the file upload first
    $imageUploadPath = ''; // Default value if no file is uploaded
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageUpload"])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/archiweb_2024_projets_gr06/public/images/recipesImages/';
        $fileName = basename($_FILES["imageUpload"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Optional: Validate file size and type here before proceeding with the upload

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFilePath)) {
            $imageUploadPath = '/public/images/recipesImages/' . $fileName;
        } else {
            // Handle file upload failure
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'File upload failed']);
            exit; // Stop execution if file upload fails
        }   
    }

    // Sanitize input data
    $name = trim($_POST['name'] ?? '');
    $calories = trim($_POST['calories'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $visibility = trim($_POST['visibility'] ?? '');
    $creationDate = trim($_POST['creation_date'] ?? '');
    $creator = trim($_POST['creator'] ?? '');

    $data = [
        'name' => $name,
        'calories' => $calories,
        'type' => $type,
        'visibility' => $visibility,
        'creation_date' => $creationDate,
        'creator' => $creator,
        'image' => $imageUploadPath 
    ];
    

    // Attempt to register the recipe
    if ($this->adminModel->addNewRecipe($data)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'redirect' => 'login.php']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Something went wrong']);
    }
}
public function deleteRecipe()
{
    if (isset($_POST['del_id'])) {
        $del_id = $_POST['del_id'];
        $result = $this->adminModel->deleteRecipeById($del_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete Recipe.']);
        }
        exit;
    }
}
    

}
