<?php

namespace Manger\Model;

use Config\Database;

define('USER_ID', ':user_id');
define('EMAIL', ':email');


/**
 * User Class
 *
 * Represents the model for managing user data.
 */
class User
{

    /**
     * @var Database The database instance.
     */
    private $db;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get All Users
     *
     * Retrieves all users for the admin dashboard.
     *
     * @return array|false An array of user data if users are found, or false if no users are present.
     */
    public function getAllUsers()
    {
        $data = array();
        $sql = "SELECT * FROM users";

        $this->db->query($sql);
        $rows = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            foreach ($rows as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    /**
     * Get User by ID
     *
     * Retrieves user details based on the provided user ID.
     *
     * @param int $userId The ID of the user.
     *
     * @return object|false An object representing the user data if found, or false if no user is found.
     */
    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id = :user_id";

        $this->db->query($sql);
        $this->db->bind(USER_ID, $userId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Find User by Email
     *
     * Retrieves user details based on the provided email address.
     *
     * @param $email The email address of the user.
     *
     * @return object|false An object representing the user data if found, or false if no user is found.
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(EMAIL, $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Register User
     *
     * Registers a new user in the database using the content of $data.
     *
     * @param array $data An associative array containing user data (fullname, password, email).
     *
     * @return bool True if the user is registered successfully, false otherwise.
     */
    public function register($data)
    {
        $this->db->query('INSERT INTO users (fullname, password, email, active, creation_date)
            VALUES (:fullname, :password, :email, 1, NOW())');

        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(EMAIL, $data['email']);

        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }



    /**
     * Login
     *
     * Find the user with the $email in the database,
     * then hash $password to compare it to the hashed password of the user previously found.
     *
     * @param  mixed $email
     * @param  mixed $password
     * @return object|false
     */
    public function login($email, $password)
    {
        $row = $this->findUserByEmail($email);

        if (!$row) {
            return false;
        }

        $hashedPassword = $row->password;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Update User Details
     *
     * Updates user details in the database based on the content of $data
     * such as fullname, goal, height, weight, and age.
     *
     * @param array $data An associative array containing user details (id, fullname, goal, height, weight, age).
     *
     * @return bool True if the user details are updated successfully, false otherwise.
     */
    public function updateUserDetails($data)
    {
        $this->db->query('UPDATE users SET fullname = :fullname, goal = :goal, height = :height,
             weight = :weight, age = :age WHERE id = :user_id');
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':goal', $data['goal']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':weight', $data['weight']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(USER_ID, $data['id']);

        return $this->db->execute();
    }

    /**
     * Update User Credentials
     *
     * Updates user credentials, such as email and password.
     *
     * @param array $data An associative array containing user credentials (id, email, old_password, new_password).
     *
     * @return bool True if the user credentials are updated successfully, false otherwise.
     */
    public function updateUserCredentials($data)
    {
        $this->db->query('SELECT password FROM users WHERE id = :user_id');
        $this->db->bind(USER_ID, $data['id']);
        $this->db->execute();
        $currentPassword = $this->db->single()->password;

        if (!password_verify($data['old_password'], $currentPassword)) {
            return false;
        }

        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);

        // Update credentials in the database
        $this->db->query('UPDATE users SET email = :email, password = :password WHERE id = :user_id');
        $this->db->bind(EMAIL, $data['email']);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(USER_ID, $data['id']);

        return $this->db->execute();
    }

    /**
     * Update User First Login
     *
     * Updates user account information in the database on first login, including goal, height, weight, age, gender, and daily calorie goal.
     *
     * @param array $data An associative array containing user data for update.
     *
     * @return bool True if the user account is updated successfully, false otherwise.
     */
    public function updateUserFirstLogin($data)
    {
        $this->db->query('UPDATE users SET goal = :goal, height = :height, weight = :weight, age = :age,
            gender= :gender,daily_caloriegoal = :dailyCalories WHERE id = :id');
        $this->db->bind(':goal', $data['goal']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':weight', $data['weight']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':dailyCalories', $data['dailyCalories']);

        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            // Handle or log the exception
            error_log("PDOException: " . $e->getMessage()); // Exception logging
            return false;
        }
    }

    /**
     * Reset Password
     *
     * Resets the user's password using the provided hashed password and email token.
     *
     * @param string $newPwdHash The hashed new password.
     * @param string $tokenEmail The email token associated with the password reset.
     *
     * @return bool True if the password is reset successfully, false otherwise.
     */
    public function resetPassword($newPwdHash, $tokenEmail)
    {
        $this->db->query('UPDATE users SET password=:pwd WHERE email=:email');
        $this->db->bind(':pwd', $newPwdHash);
        $this->db->bind(EMAIL, $tokenEmail);

        //Execute
        return $this->db->execute();
    }

    // PLANNING - RECIPES
    public function getRecipesByName($searchValue)
    {
        // session_start();

        $userId = $_SESSION['id'];

        $sql = "SELECT * FROM recipes WHERE name LIKE :searchValue AND (creator = :userId OR creator = 42)";

        $this->db->query($sql);
        $this->db->bind(':searchValue', "%$searchValue%");
        $this->db->bind(':userId', $userId);

        $results = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * getNotifsById
     * 
     * Returns the number of notifications the connected user has, and put them in the session.
     *
     * @param  mixed $userId
     * @return int|bool
     */
    public function getNotifsById($userId)
    {
        $sql = "SELECT * FROM notifications WHERE receiver_id=:userId ORDER BY type ASC";

        $this->db->query($sql);
        $this->db->bind(':userId', $userId);
        $rows = $this->db->resultSet();
        $nbrRows = $this->db->rowCount();

        $data = [];

        if ($nbrRows >= 0) {

            if ($nbrRows > 0) {
                foreach ($rows as $row) {
                    $data[] = $row;
                }
            }
            // hors du if, sinon lorsqu'il n'y a pas de notification, la session gardera l'ancienne version de $data
            $_SESSION['notifications'] = $data;
            return $nbrRows;
        } else {
            return 0;
        }
    }

    /**
     * getUsersByNotifs
     * 
     * Use the list of notifications in the database to get access to all users who sent notifications
     * to the current connected user, then put their data in an array and return it
     *
     * @return bool|object[]
     */
    public function getUsersByNotifs()
    {
        $notifList = $_SESSION['notifications'];

        if (!empty($notifList)) {
            $senderList = [];
            foreach ($notifList as $notif) {
                $sql = "SELECT * FROM users WHERE id=:senderId";
                $this->db->query($sql);
                $this->db->bind(':senderId', $notif->sender_id);
                $sender = $this->db->single();

                if ($sender) {
                    $sender->notification_type = $notif->type;
                    $senderList[] = $sender;
                }
            }
            return $senderList;
        }
        return false;
    }

    /**
     * checkIfConnectionExists
     * 
     * Check if a connection between a client and a nutritionist already exists in the nutritionist_client table
     *
     * @param int $clientId
     * @param int $nutritionistId
     * @param string $requestType The role of the connected user, regular or nutritionist
     * @return bool
     */
    private function checkIfConnectionExists($userId, $senderId, string $requestType)
    {
        $this->db->query("SELECT * FROM nutritionist_client WHERE client_id = :clientId AND nutritionist_id = :nutritionistId");

        if ($requestType == "Regular") {
            $this->db->bind(':clientId', $userId);
            $this->db->bind(':nutritionistId', $senderId);
        } else if ($requestType == "Nutritionist") {
            $this->db->bind(':clientId', $senderId);
            $this->db->bind(':nutritionistId', $userId);
        }
        $this->db->execute();

        return $this->db->fetchCount(); // récupère le résultat COUNT(*)
    }


    /**
     * Add or Delete a connection into the nutritionist_client table.
     * 
     * @param string $userRole The role of the user.
     * @param int $senderId The ID of the sender.
     * @param int $userId The ID of the user.
     * @param Database $db The database connection.
     * @param string $requestType The type of request to execute, can be either "insert" or "delete"
     * @return array An array indicating success or failure along with a message.
     */
    private function modifyConnection($userRole, $senderId, $userId, $db, string $requestType)
    {
        if ($requestType == "insert") {
            if ($userRole == "Nutritionist") {
                $query = "INSERT INTO nutritionist_client (`client_id`, `nutritionist_id`) VALUES (:senderId, :userId)";
            } else if ($userRole == "Regular") {
                $query = "INSERT INTO nutritionist_client (`client_id`, `nutritionist_id`) VALUES (:userId, :senderId)";
            } else {
                return array(false, "Neither client nor nutritionist");
            }
        } else if ($requestType == "delete") {
            if ($userRole == "Nutritionist") {
                $query = "DELETE FROM nutritionist_client WHERE `client_id` = :senderId AND `nutritionist_id` = :userId";
            } else if ($userRole == "Regular") {
                $query = "DELETE FROM nutritionist_client WHERE `client_id` = :userId AND `nutritionist_id` = :senderId";
            } else {
                return array(false, "Neither client nor nutritionist");
            }
        }

        // Exécuter la requête d'insertion
        $db->query($query);
        $db->bind(':senderId', $senderId);
        $db->bind(':userId', $userId);
        if (!$db->execute()) {
            $returnMessage = "Couldn't " . $requestType . " nutritionist_client table";
            return array(false, $returnMessage);
        }

        return array(true, $requestType . "ed successfully");
    }


    /**
     * updateNotificationState
     * 
     * Modify the notification in the table, depending of if it was declined or accepted,
     * then add the connection between the nutritionist and the regular user in the nutritionist_client table
     *
     * @return array
     */
    public function updateNotificationState()
    {

        $notifState = $_POST['notifState'];
        $senderId = $_POST['senderId'];
        $userRole = $_SESSION['role'];
        $userId = $_SESSION['id'];

        if ($notifState == "Accept") {
            $newNotifState = 2;
        } else if ($notifState == "Decline") {
            $newNotifState = 3;
        } else {
            $returnMessage = "Parameter not allowed: " . $notifState;
            return array(false, $returnMessage);
        }


        $this->db->query('UPDATE notifications SET type=:newState WHERE sender_id=:senderId AND receiver_id=:userId AND type=1');
        $this->db->bind(':newState', $newNotifState);
        $this->db->bind(':senderId', $senderId);
        $this->db->bind(':userId', $userId);

        if (!$this->db->execute()) {
            $returnMessage = "Couldn't update notification table";
            return array(false, $returnMessage);
        }

        if ($newNotifState == 2) { // If Accept -> insertion
            if (!$this->checkIfConnectionExists($userId, $senderId, $userRole)) {
                return $this->modifyConnection($userRole, $senderId, $userId, $this->db, "insert");
            } else {
                return array(false, "Connection already exists");
            }
        } else if ($newNotifState == 3) { // If Decline -> deletion
            if ($this->checkIfConnectionExists($userId, $senderId, $userRole)) { // regarde si la connexion existe avant
                return $this->modifyConnection($userRole, $senderId, $userId, $this->db, "delete");
            } else {
                return array(false, "No connection to delete between " . $userId . " and " . $senderId);
            }
        } else {
            return array(false, "Notification State " . $newNotifState . " not allowed");
        }
    }
}
