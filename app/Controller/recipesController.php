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
    //-----------------Get All Recipes-----------------------
    function recipesCont()
    {
        header('Content-Type: application/json');
        $recipes = $this->obj->getRecipesList();
        // Start output buffering
        ob_start();
        // Include the view file, the $data variable will be used there
        require VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'recipes' . DS . "recipes-table.php";

        // Store the buffer content into ¨$output variable
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

    //---------------Add New Recipes---------------------
    function addNewRecipe()
    {

        $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_EMAIL);
        $calories = trim($_POST['calories'] ?? '');
        $file = $_FILES['img_url'];
        
            echo '<script>';
            echo 'console.log("eee' . $file . '");'; // Imprime le message dans la console du navigateur
            echo '</script>';
            // Check if file was uploaded without errors
            if ($file['error'] == UPLOAD_ERR_OK) {
                // File is in $file['tmp_name']
                $tempFilePath = $file['tmp_name'];

                // You can move the uploaded file to a permanent location
                $destination = BASE_APP_DIR+'public/images/recipesImages/'.basename($file['name']);
                move_uploaded_file($tempFilePath, $destination);

                // Initialize data.............
                $data = [
                    'name' => $name,
                    'calories' => $calories,
                    'image_url' => $file

                ];

                if ($this->obj->addRecipe($data)) {
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => "there is a probleme to add"]);
                    exit;
                };
            }
       
    }
}
