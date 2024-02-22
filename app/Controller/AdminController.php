<?php

namespace Manger\Controller;

use Manger\Model\AdminModel;
use Manger\Views\UserView;
use Manger\Views\AdminView;
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
     * Constructor
     *
     * Initializes the Admins Controller with the Admin Model.
     */
    public function __construct()
    {
        $this->adminModel = new AdminModel();
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
}
