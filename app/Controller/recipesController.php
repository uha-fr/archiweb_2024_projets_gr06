<?php
namespace Manger\Controller;

use Manger\Model\RecipesModel; // fonctionnel
 
class RecipesController{

    private $obj;

    public function __construct()
    {
        $this->obj= New RecipesModel();
    }
//-----------------Get All Recipes
function recipesCont()
{
    header('Content-Type: application/json');
    $recipes = $this->obj->getRecipesList();
        // Start output buffering
        ob_start();
        // Include the view file, the $data variable will be used there
        require VIEWSDIR.DS.'components'.DS.'user'.DS.'recipes'.DS."recipes-table.php";
        
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
    function addNewRecipe() {

        $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_EMAIL);
        $calories= trim($_POST['calories'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');
    
        // Initialize data.............
        $data = [
            'name' => $name,
            'calories' => $calories,
            'image_url' => $image_url
               ];
       
       if($this->obj->addRecipe($data))
        {
            echo json_encode(['success' =>true]);
            exit;
        }
        else{
            echo json_encode(['success' =>false,'message'=>"there is a probleme to add"]);
            exit;
        };
    }
    
}
?>