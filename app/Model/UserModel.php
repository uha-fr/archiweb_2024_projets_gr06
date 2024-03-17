<?php

namespace Manger\Model;

use Config\Database;



/**
 * User Class
 *
 * Represents the model for managing user data.
 */
class UserModel
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

        $params = [
            ':fullname',
            ':password',
            EMAIL
        ];
        $this->db->bindMultipleParams($params, $data);

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
        $sql = 'UPDATE users SET fullname = :fullname, img= :img, goal = :goal, height = :height,
             weight = :weight, age = :age WHERE id = :user_id';

        $params = [
            USER_ID,
            ':img',
            ':fullname',
            ':goal',
            ':height',
            ':weight',
            ':age'
        ];

        $this->db->query($sql);
        $this->db->bindMultipleParams($params, $data);

        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            // Handle or log the exception
            error_log("PDOException: " . $e->getMessage() . "\nSQL: " . $sql . "\nParams: " . print_r($params, true) . "\Data: " . print_r($data, true)); // Log details
            return false;
        }
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

        $params = [
            USER_ID,
            EMAIL,
            ':password'
        ];
        $this->db->bindMultipleParams($params, [$data['id'], $data['email'], $hashedPassword]);

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
        $sql = 'UPDATE users SET goal = :goal,fullname = :fullname, height = :height, weight = :weight, age = :age,
            gender= :gender,daily_caloriegoal = :dailyCalories WHERE id = :id';


        $params = [
            ':id',
            ':fullname',
            ':goal',
            ':height',
            ':weight',
            ':age',
            ':gender',
            ':dailyCalories'
        ];
        $this->db->query($sql);
        $this->db->bindMultipleParams($params, $data);

        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            // Handle or log the exception
            error_log("PDOException: " . $e->getMessage() . "\nSQL: " . $sql . "\nParams: " . print_r($params, true) . "\Data: " . print_r($data, true)); // Log details
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
        $this->db->bindMultipleParams([':pwd', EMAIL], [$newPwdHash, $tokenEmail]);
        return $this->db->execute();
    }

    // PLANNING - RECIPES
    public function getRecipesByName($searchValue)
    {
        // session_start();

        $userId = $_SESSION['id'];
        $sql = "SELECT * FROM recipes WHERE name LIKE :searchValue AND (creator = :userId OR creator = 42)";
        $this->db->query($sql);
        $this->db->bindMultipleParams([':searchValue', ':userId'], ["%$searchValue%", $userId]);

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
            $this->db->bindMultipleParams([':clientId', ':nutritionistId'], [$userId, $senderId]);
        } else if ($requestType == "Nutritionist") {
            $this->db->bindMultipleParams([':clientId', ':nutritionistId'], [$senderId, $userId]);
        }
        $this->db->execute();

        return $this->db->fetchCount(); // récupère le résultat COUNT(*)
    }

    /**
     * Retrieves user information based on the user's ID.
     *
     * @param int $senderId The ID of the user.
     * @return mixed The user information or false in case of an error.
     */
    public function getSingleUserById($senderId)
    {
        $sql = "SELECT * FROM users WHERE id = :senderId";
        $this->db->query($sql);
        $this->db->bind(':senderId', $senderId);
        return $this->db->single();
    }



    /**
     * Add or Delete a connection into the nutritionist_client table.
     * 
     * @param string $userRole The role of the user.
     * @param int $senderId The ID of the sender.
     * @param int $userId The ID of the user.
     * @param Database $db The database connection.
     * @param string $requestType The type of request to execute, can be either "insert" or "delete"
     * @return array An array indicating success or failure along with a message, and if success, the data of the sender
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


        return array(true, $this->getSingleUserById($senderId), $requestType);
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
        $this->db->bindMultipleParams([':newState', ':senderId', ':userId'], [$newNotifState, $senderId, $userId]);


        if (!$this->db->execute()) {
            $returnMessage = "Couldn't update notification table";
            return array(false, $returnMessage);
        }

        if ($newNotifState == 2) { // If Accept -> insertion
            if (!$this->checkIfConnectionExists($userId, $senderId, $userRole)) {
                return $this->modifyConnection($userRole, $senderId, $userId, $this->db, "insert");
            } else {
                return array(true, $this->getSingleUserById($senderId), "insert"); // cas où A envoie une notif que B accepte, puis B envoie une notif que A veut accepter

            }
        } else if ($newNotifState == 3) { // If Decline -> deletion
            if ($this->checkIfConnectionExists($userId, $senderId, $userRole)) { // regarde si la connexion existe avant
                return $this->modifyConnection($userRole, $senderId, $userId, $this->db, "delete");
            } else {
                return array(true, $this->getSingleUserById($senderId), "delete"); // cas où décline, et pas déjà de connection dans la db
            }
        } else {
            return array(false, "Notification State " . $newNotifState . " not allowed");
        }
    }
    /**
     * get all recipes
     *
     * @return array|bool
     */
    function getRecipesList()
    {
        $sql = "SELECT * FROM recipes";
        $this->db->query($sql);
        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    /**
     * add Recipe
     * 
     * Add recipe from the parameters, in the database
     *
     * @param  mixed $donnees
     * @return bool
     */
    function addRecipe($donnees)
    {

        $sql = "INSERT INTO  recipes(name,calories,image_url) VALUES (:name, :calories, :image_url )";
        $this->db->query($sql);

        $this->db->bindMultipleParams([':name', ':calories', ':image_url'], $donnees);

        try {
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            // Handle exception
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }
    /**
     * addUserPlan
     * 
     * This function adds a new plan for the user based on the provided data. If a plan name
     * is not provided, it defaults to "Default Plan for User" followed by the user's ID. 
     * The plan details are inserted into the plans table, and the user-plan relationship 
     * is stored in the user_plan table. Additionally, each recipe in the plan is inserted 
     * into the plan_recipes table.
     * 
     * @param array $recipesData An array containing information about the recipes in the plan
     * @param int $period The number of days of the plan (repeats through the duration)
     * @param int $duration The total number of days of the plan
     * @param string|null $plan_name The name of the plan (optional)
     * @return bool Returns true if the plan is successfully added, false otherwise
     */
    function addUserPlan($recipesData, $period, $duration, $plan_name)
    {
        $userId = $_SESSION['id']; //  user ID from the session
        // Insert into the `plans` table
        $planName = $plan_name ??  "Default Plan for User " . $userId;
        $creatorId = $_SESSION['id']; //  user ID from the session
        $type = "Your Plan Type"; // You can define a type for the plan
        $sql = "INSERT INTO plans (name, period, total_length, creator, type) VALUES (:name, :period, :total_length, :creator, :type)";
        $this->db->query($sql);
        $params_dict = [
            ":name",
            ":period",
            ":total_length",
            ":creator",
            ":type",
        ];

        $values_dict = [
            $plan_name,
            $period,
            $duration,
            $creatorId,
            $type
        ];
        $this->db->bindMultipleParams($params_dict, $values_dict);

        $this->db->execute();
        $planId = $this->db->lastInsertId(); // Get the ID of the inserted plan

        $sql = "INSERT INTO user_plan (user_id, plan_id, creation_date) VALUES (:user_id, :plan_id, NOW())";
        $this->db->query($sql);
        $this->db->bindMultipleParams([':user_id', ':plan_id'], [$userId, $planId]);
        $this->db->execute();

        foreach ($recipesData as $recipe) {
            $recipeId = $recipe['id'];
            $date = $recipe['date'];

            $sql = "INSERT INTO plan_recipes (plan_id, recipe_id, date) VALUES (:plan_id, :recipe_id, :date)";
            $this->db->query($sql);
            $this->db->bindMultipleParams([':recipe_id', ':plan_id', ':date'], [$recipeId, $planId, $date]);
            $this->db->execute();
        }
        return true;
    }
    /**
     * Checks if a user has a plan in the database.
     *
     * This function checks if a user has a plan recorded in the user_plan table
     * of the database based on their user ID.
     *
     * @param int $userId The ID of the user to check.
     *
     * @return bool True if the user has a plan, otherwise False.
     */
    function ifUserHavePlan()
    {
        $userId = $_SESSION['id']; // ID de l'utilisateur depuis la session
        $sql = "SELECT EXISTS (SELECT 1 FROM user_plan WHERE user_id = :userId) AS planExists";
        $this->db->query($sql);
        $this->db->bind(':userId', $userId);
        $result = $this->db->single(); // Récupère le résultat de la clause EXISTS

        if ($result->planExists == 1) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * getUserPlan
     * 
     * Retrieves the plan associated with the specified user ID from the database.
     * 
     * @param int $userId The ID of the user to retrieve the plan for.
     * @return mixed Returns the plan details if found, or false if no plan exists for the user.
     */

    function getUserPlan($userId)
    {
        $sql = "SELECT * FROM user_plan WHERE user_id = :userId";
        $this->db->query($sql);
        $this->db->bind(':userId', $userId);
        $plan = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return $plan;
        } else {
            return false;
        }
    }
    /**
     * getPlanInfo
     * 
     * get all information about user plan from plans table 
     * 
     * @param int $planId The ID of the plan to retrieve the plan information.
     * @return mixed Returns the plan information if found, or false if no plan exist.
     */
    function getPlanInfo($planId)
    {
        $sql = "SELECT * FROM plans WHERE id = :planId";
        $this->db->query($sql);
        $this->db->bind(':planId', $planId);
        $plan = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return $plan;
        } else {
            return false;
        }
    }
    /**
     * getRecipesAndDay
     *
     * Retrieves recipes along with their associated day from the database based on the provided plan ID.
     * @param int $planId The ID of the plan for which recipes are being retrieved.
     * @return array An array containing recipe information along with their associated day, or an empty array if no recipes are found.
     */
    function getRecipesAndDay($planId)
    {
        $sql = "SELECT r.*, pr.date FROM recipes r JOIN plan_recipes pr ON r.id = pr.recipe_id WHERE pr.plan_id = :planId";
        $this->db->query($sql);
        $this->db->bind(':planId', $planId);
        $recipes = $this->db->resultSet();
        return $recipes;
    }
    /**
     * getPlanRecipesDetail
     * 
     * Retrieves the details of recipes associated with the user's plan from the database.
     * This function first retrieves the user's plan using the getUserPlan method,
     * then fetches the details of recipes associated with the retrieved plan using the getPlanRecipesDetails method.
     * 
     * @return array|null Returns an array containing the details of recipes associated with the user's plan.
     *                   If no plan is found for the user or if no recipes are associated with the plan, returns null.
     */

    function getPlanRecipesDetail()
    {
        // Récupération du plan de l'utilisateur
        $userId = $_SESSION['id'];
        $plan = $this->getUserPlan($userId);
        $planId = $plan->id;
        $planInfo = $this->getPlanInfo($planId);
        $planRecipesDetails = $this->getRecipesAndDay($planId);
        $result = array(
            'planData' => $planInfo,
            'planRecipesDetails' => $planRecipesDetails
        );
        return $result;
    }
}
