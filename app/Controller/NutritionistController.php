<?php

namespace Manger\Controller;

use Manger\Model\NutritionistModel;

/**
 * Controller for Nutritionist-related things.
 * 
 * Handle actions such as adding clients, sending them notifications.
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
     * Initializes the Nutritionists Controller with the Nutritionist Model.
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
        header('APPJSON');
        $searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

        if (!empty($searchValue)) {
            $data = $this->nutriModel->getUserByFullname($searchValue, $_SESSION['role']);

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

    /**
     * sendNotification
     * 
     * Check if there's an ID in the POST request. If so, send it with the session ID so the Model can use them with the database
     *
     * @return void
     */
    public function sendNotification()
    {
        header('APPJSON');
        $idReceiver = isset($_POST['receiverId']) ? $_POST['receiverId'] : '';

        if (!empty($idReceiver)) {
            $data = $this->nutriModel->checkNotifThenSend($idReceiver, $_SESSION['id']);

            if ($data) {
                // envoi du mail avec $data['email']
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user ID provided for notification.']);
        }
    }


    /**
     * Show All Cients for a Nutritionist
     *
     * Retrieves all clients for a given nutritionist from the model and display them through <strong>clients-table.php</strong>.
     *
     * @param int $nutritionistId The ID of the nutritionist
     * @return void
     */
    public function getUsersForNutritionist()
    {
        header('APPJSON');
        $nutritionistId = isset($_GET['nutri_id']) ? $_GET['nutri_id'] : '';

        // Call the model method to get users for the nutritionist
        $data = $this->nutriModel->getUsersForNutritionist($nutritionistId);

        if ($data) {
            // Output buffering to capture the included file's content
            ob_start();
            include VIEWSDIR . DS . 'components' . DS . 'nutritionist' . DS . 'list-client-element.php';
            $output = ob_get_clean();

            // Echo the content captured, which now includes $data being used in usersList.php
            echo json_encode(['message' => $output]);
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">:( No clients present for this nutritionist!</h3>']);
        }
        exit;
    }
}
