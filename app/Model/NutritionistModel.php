<?php

namespace Manger\Model;

use Config\Database;

/**
 * NutritionistModel Class
 *
 * Represents the model for managing nutritionist data.
 */
class NutritionistModel
{
    /**
     * @var Database The database instance.
     */
    private $db;

    /**
     * Admin constructor.
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
    public function getUserByFullname($namePart)
    {
        $sql = "SELECT * FROM users WHERE fullname LIKE CONCAT('%', :namePart, '%');";
        $this->db->query($sql);
        $this->db->bind(':namePart', $namePart);

        $results = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $results;
        } else {
            return false;
        }
    }
}
