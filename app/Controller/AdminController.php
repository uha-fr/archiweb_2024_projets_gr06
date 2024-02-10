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
    public function showAllUsers()
    {
        header('Content-Type: application/json');
        $data = $this->adminModel->getAllUsers();

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
     * Retrieves and returns the count of users with a role of 'regular'.
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
