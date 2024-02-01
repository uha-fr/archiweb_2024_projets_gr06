<?php

namespace Manger\Controller;

use Manger\Model\RecipesModel; // fonctionnel

class RecipesController
{

    private $obj;

    public function __construct()
    {
        $this->obj = new RecipesModel();
    }

    function recipesCont()
    {
        header('Content-Type: application/json');
        $recipes = $this->obj->getRecipesList();
        // Start output buffering
        ob_start();
        // Include the view file and use $recipes variable to show the recipes array as a table
        require VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'recipes' . DS . "recipes-table.php";

        // Store the buffer content in $output
        $output = ob_get_clean();

        // Return JSON
        if ($recipes) {
            echo json_encode(['message' => $output]);
            exit;
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">No recipe found!!</h3>']);
            exit;
        }
    }
}
