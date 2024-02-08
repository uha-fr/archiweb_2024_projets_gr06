<?php
namespace Manger\Model;
use Config\Database;
class RecipesModel
{
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }
    //-----------------------get recipes list from DataBase--------------------

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
    //-----------------------add New recipe To DataBase--------------------
    function addRecipe($donnees)
    {

        $sql = "INSERT INTO  recipes(name,calories,image_url) VALUES (:name, :calories, :image_url )";
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
            // Handle exception
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }
}
