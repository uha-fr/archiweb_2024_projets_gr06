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
     * Get All Recipes
     * 
     * This method prepares an SQL query to select all columns from the recipes table 
     * where the ID matches the provided recipe ID. 
     * It then binds the provided ID to the query to ensure a safe query execution.
     * 
     * After executing the query, it attempts to fetch a single row from the result set. If a recipe with the 
     * specified ID exists, the function returns an associative array containing the recipe's details. If no 
     * recipe is found with the given ID, or if the query fails for any reason, the function returns false.
     * 
     * This method allows for the retrieval of detailed information about a specific recipe, making it useful 
     * for displaying recipe details on a webpage or within an application.
     * 
     * @param int|string $recipeId The unique identifier for the recipe to retrieve. The type can be int or string, 
     *                             depending on how the ID is stored in the database.
     * @return mixed Returns an associative array of the recipe's details if found, false otherwise.
     */
    public function getAllRecipes()
    {
        $data = array();
        $sql = "SELECT * FROM recipes";

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
     * Get Recipe By ID
     * 
     * Retrieves a single recipe from the database using its unique identifier (ID). This method executes a SQL query
     * to select a recipe where the 'id' column matches the provided ID. The method uses prepared statements to bind
     * the ID parameter, enhancing security by preventing SQL injection attacks.
     * 
     * Upon execution, if a recipe with the specified ID is found, the method returns an associative array containing
     * the recipe's details, such as its name, calories, type, image URL, and others as per the database schema. If no
     * recipe is found matching the provided ID (e.g., if the ID does not exist in the database), the method returns false.
     * 
     * This method is particularly useful for fetching detailed information about a specific recipe, for instance, when
     * displaying the recipe's details on a webpage or within an application's UI.
     * 
     * @param int|string $recipeId The unique identifier of the recipe to retrieve. The type can be int or string,
     *                             depending on the database design.
     * @return object|bool An associative array containing the recipe's details if found, or false if no recipe
     *                    matches the provided ID.
     */
    public function getRecipeById($recipeId)
    {
        $sql = "SELECT * from recipes where id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $recipeId);

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
     * Add New User 
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

    /**
     * Add New Recipe
     * 
     * Inserts a new recipe into the database with the provided data. This function prepares an SQL insert query,
     * binds the input data to the query parameters, and executes the query. The data is expected to include 
     * details about the recipe such as name, calories, type (e.g., vegetarian, non-vegetarian), image URL, 
     * visibility status (e.g., public, private), creation date, and the creator's identifier.
     * 
     * If the database operation is successful, the function returns true, indicating that the recipe has been 
     * added successfully. In case of a database error, the error is caught, and the function returns false. 
     * This error handling mechanism ensures that the application can gracefully handle database exceptions without 
     * crashing.
     * 
     * @param array $data An associative array containing the recipe's details. Expected keys are 'name', 'calories', 
     *                    'type', 'image', 'visibility', 'creation_date', and 'creator'.
     * @return bool Returns true if the recipe was successfully added to the database, false otherwise.
     */
    public function addNewRecipe($data)
    {
        // Prepare SQL query to insert recipe data into the database.
        $this->db->query('INSERT INTO recipes (name, calories, type, image_url, visibility, creation_date, creator)
        VALUES (:name, :calories, :type, :image_url, :visibility, :creation_date, :creator)');

        // Bind parameters to the query.
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':calories', $data['calories']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':image_url', $data['image']);
        $this->db->bind(':visibility', $data['visibility']);
        $this->db->bind(':creation_date', $data['creation_date']);
        $this->db->bind(':creator', $data['creator']);

        // Execute the query and handle any exceptions.
        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            // Log or handle the database error accordingly.
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }
    /**
     * Update Recipe
     *
     * Updates an existing recipe in the database with the provided data. This function prepares an SQL update query,
     * binds the input data to the query parameters, and executes the query. The data is expected to include
     * the recipe's identifier, as well as the updated details such as name, calories, type (e.g., vegetarian, non-vegetarian),
     * image URL, visibility status (e.g., public, private), and the creator's identifier.
     *
     * If the database operation is successful, the function returns true, indicating that the recipe has been
     * updated successfully. In case of a database error, the error is caught, and the function returns false.
     * This error handling mechanism ensures that the application can gracefully handle database exceptions without
     * crashing.
     *
     * @param array $data An associative array containing the recipe's updated details. Expected keys are 'id', 'name', 'calories',
     *                    'type', 'image', 'visibility', and 'creator'.
     * @return bool Returns true if the recipe was successfully updated in the database, false otherwise.
     */
    public function updateRecipe($data)
    {
        // Prepare SQL query to update recipe data in the database.
        $this->db->query('UPDATE recipes SET name = :name, calories = :calories, type = :type, image_url = :image_url, visibility = :visibility WHERE id = :id');

        // Bind parameters to the query.
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':calories', $data['calories']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':image_url', $data['image']);
        $this->db->bind(':visibility', $data['visibility']);

        // Execute the query and handle any exceptions.
        try {
            return $this->db->execute();
        } catch (\PDOException $e) {
            // Log or handle the database error accordingly.
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }
    /**
     * Delete Recipe By ID
     * 
     * Deletes a recipe from the database based on the provided unique identifier (ID). This function prepares
     * an SQL delete query using the recipe's ID to identify the specific record to be removed. The ID is bound
     * to the prepared statement to safely execute the deletion operation.
     * 
     * The function executes the prepared query. If the deletion is successful, it returns true, indicating that
     * the record has been successfully removed from the database. If the deletion fails for any reason, the function
     * returns false. This return value can be used to determine the success of the deletion operation and to provide
     * appropriate feedback to the user or to trigger further actions within the application.
     * 
     * @param int|string $id The unique identifier of the recipe to be deleted. The type can be int or string,
     *                       depending on the database design.
     * @return bool Returns true if the recipe was successfully deleted from the database, false otherwise.
     */
    public function deleteRecipeById($id)
    {
        $sql = "DELETE FROM recipes WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
