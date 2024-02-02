<?php

namespace Manger\Model;

use Config\Database;

class User
{

    private $db;

    public function __construct()
    {

        $this->db = new Database();
    }

    //Get all users for admin dashboard
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

    //Get user details by ID
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


    //Find user by Email
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

    //Register function
    public function register($data)
    {
        $this->db->query('INSERT INTO users (fullname,password,email,active,creation_date)
        VALUES ( :fullname, :passwordd , :email , 1 , NOW() )');

        // Bind the data from the $data array to the named placeholders
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':passwordd', $data['password']);
        $this->db->bind(':email', $data['email']);

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

    //Login user
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

    //Update user details
    public function update_user_details($data)
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

    //Update user credentials (New password)
    public function update_user_credentials($data)
    {
        $this->db->query('SELECT password FROM users WHERE id = :user_id');
        $this->db->bind(':user_id', $data['id']);
        $this->db->execute();
        $currentPassword = $this->db->single()->password;

        // Verify old password
        if (!password_verify($data['old_password'], $currentPassword)) {
            return false; // Old password does not match
        }

        // Hash new password
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

    // First login complete user account informations
    public function update_user_first_login($data)
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
    //Reset Password
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
