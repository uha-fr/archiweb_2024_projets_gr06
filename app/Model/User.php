<?php

namespace Manger\Model;

use Config\Database;

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
        $this->db->bind(':user_id', $userId);

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
     * @param string $email The email address of the user.
     *
     * @return object|false An object representing the user data if found, or false if no user is found.
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

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
        $this->db->bind(':email', $data['email']);

        try {
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }



    //Login user    
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

        if ($row == false) return false;

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
        $this->db->query('UPDATE users SET fullname = :fullname, goal = :goal, height = :height, weight = :weight, age = :age WHERE id = :user_id');
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':goal', $data['goal']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':weight', $data['weight']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':user_id', $data['id']);

        if ($this->db->execute()) {
            return true;
        } else {
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
        $this->db->bind(':user_id', $data['id']);
        $this->db->execute();
        $currentPassword = $this->db->single()->password;

        if (!password_verify($data['old_password'], $currentPassword)) {
            return false;
        }

        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);

        // Update credentials in the database
        $this->db->query('UPDATE users SET email = :email, password = :password WHERE id = :user_id');
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':user_id', $data['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
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
        $this->db->query('UPDATE users SET goal = :goal, height = :height, weight = :weight, age = :age, gender= :gender,daily_caloriegoal = :dailyCalories WHERE id = :id');
        $this->db->bind(':goal', $data['goal']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':weight', $data['weight']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':dailyCalories', $data['dailyCalories']);

        try {
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
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
        $this->db->bind(':email', $tokenEmail);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
