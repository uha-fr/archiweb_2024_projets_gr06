<?php

namespace Manger\Model;

use Config\Database;

/**
 * Admin Class
 *
 * Represents the model for managing admin data.
 */
class AdminModel
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
 * Get Count of Regular Users
 *
 * Returns the number of users with the role of 'regular'.
 *
 * @return int The count of regular users.
 */
public function getRegularUsersCount()
{
    $sql = "SELECT COUNT(*) AS regularCount FROM users WHERE role = :role";

    $this->db->query($sql);
    $this->db->bind(':role', 'Regular');
    $this->db->execute();
    
    $row = $this->db->single(); // Assuming single() fetches a single record as an object
    
    if ($row) {
        return $row->regularCount;
    } else {
        return 0; // In case of no users or an error
    }
}
/**
 * Get Count of Nutritionist Users
 *
 * Returns the number of users with the role of 'nutritionist'.
 *
 * @return int The count of nutritionist users.
 */
public function getNutritionistCount()
{
    $sql = "SELECT COUNT(*) AS regularCount FROM users WHERE role = :role";

    $this->db->query($sql);
    $this->db->bind(':role', 'Nutritionist');
    $this->db->execute();
    
    $row = $this->db->single(); // Assuming single() fetches a single record as an object
    
    if ($row) {
        return $row->regularCount;
    } else {
        return 0; // In case of no users or an error
    }
}

}
