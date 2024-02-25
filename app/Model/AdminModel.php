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
     * Deletes a user by their ID.
     *
     * This method executes a DELETE SQL statement to remove a user from the database.
     * It uses prepared statements to prevent SQL injection attacks.
     *
     * @param int $id The unique identifier of the user to be deleted.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    public function deleteUserById($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Fetch a single user by ID.
     *
     * Retrieves a user from the database based on the provided ID and returns it.
     * If the user is found, their data is returned. Otherwise, false is returned.
     *
     * @param int $userId The ID of the user to retrieve.
     * @return mixed The user data as an object if found, otherwise false.
     */
    public function getUserById($userId)
    {
        $sql = "SELECT * from users where id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $userId);

        $row = $this->db->single();

        if ($row) {
            return $row;
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
        $sql = "SELECT COUNT(*) AS nutritionistCount FROM users WHERE role = :role";

        $this->db->query($sql);
        $this->db->bind(':role', 'Nutritionist');
        $this->db->execute();

        $row = $this->db->single(); // Assuming single() fetches a single record as an object

        if ($row) {
            return $row->nutritionistCount;
        } else {
            return 0; // In case of no users or an error
        }
    }




    /**
     * Get Count of Recipes
     *
     * Returns the number of Recipes.
     *
     * @return int The count of Recipes.
     */
    public function getRecipesCount()
    {
        $sql = "SELECT COUNT(*) AS recipeCount FROM recipes";

        $this->db->query($sql);
        $this->db->execute();

        $row = $this->db->single(); // Assuming single() fetches a single record as an object


        if ($row) {
            return $row->recipeCount;
        } else {
            return 0; // In case of no users or an error
        }
    }


    /**
 * add New User 
 *
 * add a new user in the database using the content of $data, including their profile image.
 * It executes a prepared statement to insert the user's data into the database.
 * If the operation is successful, it returns true, otherwise false.
 *
 * @param array $data An associative array containing user data (fullname, password, email, image).
 * @return bool True if the user is added successfully, false otherwise.
 */
public function addNewUser($data)
{
    // Prepare SQL query to insert user data into the database.
    $this->db->query('INSERT INTO users (fullname, password, email, img, active, creation_date)
                      VALUES (:fullname, :password, :email, :profile_image, 1, NOW())');

    // Bind parameters to the query.
    $this->db->bind(':fullname', $data['fullname']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':profile_image', $data['image']);

    // Execute the query and handle any exceptions.
    try {
        return $this->db->execute();
    } catch (\PDOException $e) {
        // Log or handle the database error accordingly.
        echo "Database error: " . $e->getMessage();
        return false;
    }
}





}
