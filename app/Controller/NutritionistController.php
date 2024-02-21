<?php

namespace Manger\Controller;

use Manger\Model\NutritionistModel;
use PDOException;

/**
 * Controller for Admin-related things.
 * 
 * Handle actions such as registration, login, logout, and all modifications of attributes.
 */
class NutritionistController
{

    /**
     * nutriModel
     *
     * @var NutritionistModel
     */
    private $nutriModel;


    /**
     * Constructor
     *
     * Initializes the Admins Controller with the Admin Model.
     */
    public function __construct()
    {
        $this->nutriModel = new NutritionistModel();
    }


    /**
     * Fetch and display users
     *
     * Fetch and display all users with a fullnamem matching the parameter from the GET request
     * @return void Outputs the user data in JSON format.
     */
    public function getClientList()
    {
        header('Content-Type: application/json');
        $searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

        if (!empty($searchValue)) {
            $data = $this->nutriModel->getUserByFullname($searchValue);

            if ($data) {
                ob_start();
                include VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'planning' . DS . 'searchResultsUser.php';
                $output = ob_get_clean();
                echo json_encode(['success' => true, 'data' => $output]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user ID provided.']);
        }
        exit;
    }
}
