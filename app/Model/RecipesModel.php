<?php 
namespace Manger\Model;
use Config\Database;


class RecipesModel{
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

function getRecipesList()
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

}