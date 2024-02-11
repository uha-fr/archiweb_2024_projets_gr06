<?php

namespace Manger\Controller;

use Manger\Model\RecipesModel;

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
        if ($recipes == false) {
            echo json_encode(['message' => '<h1 class="text-center text-secondary mt-5 display-3">No recipe found!!</h1>']);
            exit;
        } else {
            ob_start();
            // Include the view file, the $data variable will be used there
            require VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'recipes' . DS . "recipes-table.php";
            // Store the buffer content into ¨$output variable
            $output = ob_get_clean();
            echo json_encode(['message' => $output]);
            exit;
        }
    }
    //---------------Add New Recipes---------------------
    function addNewRecipe()
    {
        $name = $_POST['name'];
        $calories = $_POST['calories'];
        $File = $_FILES['file'];
        // Check if file was uploaded without errors
        if ($File['error'] == UPLOAD_ERR_OK) {
            // File is in $file['tmp_name']
            $tempFilePath = $File['tmp_name'];

            $destinationDirectory = 'public/images/recipesImages/';
            if (!file_exists($destinationDirectory)) {
                mkdir($destinationDirectory, 0777, true); // Création de dossier de destination s'il n'existe pas
            }
            $destination = $destinationDirectory . $_FILES['file']['name']; // Chemin de destination complet
            move_uploaded_file($tempFilePath, $destination);
            // Initialize data.............
            $data = [
                'name' => $name,
                'calories' => $calories,
                'image_url' => $_FILES['file']['name'] //nom de l'image
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
