<?php

namespace Manger\Model;

use Config\Database;

/**
 * RecipesModel Class
 *
 * Represents the model for managing recipes data from the database.
 */
class RecipesModel
{
    /**
     * @var Database The Database instance, that will link RecipesModel to the database.
     */
    private $db;

    /**
     * RecipesModel constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get Recipes List
     *
     * Retrieves the list of recipes from the database.
     *
     * @return array|false An associative array representing the recipe data if found, or false if no recipes are found.
     */
    public function getRecipesList()
    {
        $sql = "SELECT * FROM recipes";
        $this->db->query($sql);
        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Add New Recipe
     *
     * Adds a new recipe to the database using the parameters in $donnees.
     *
     * @param array $donnees An associative array containing recipe data.
     *
     * @return bool True if the recipe is added successfully, false otherwise.
     */
    public function addRecipe($donnees)
    {
        $sql = "INSERT INTO recipes (id, name, calories, image_url) VALUES (33, :name, :calories, :image_url)";
        $this->db->query($sql);
        $this->db->bind(':name', $donnees['name']);
        $this->db->bind(':calories', $donnees['calories']);
        $this->db->bind(':image_url', $donnees['image_url']);

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
}
