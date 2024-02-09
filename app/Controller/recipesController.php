<?php

namespace Manger\Controller;

use Manger\Model\RecipesModel;

/**
 * RecipesController Class
 *
 * Handles the control logic for recipes-related actions, such as retrieving recipes and adding new recipes.
 */
class RecipesController
{

    /**
     * @var RecipesModel $obj An instance of the RecipesModel class for accessing recipe data.
     */
    private $obj;

    /**
     * RecipesController constructor.
     *
     * Initializes a new instance of the RecipesController with an associated RecipesModel instance.
     */
    public function __construct()
    {
        $this->obj = new RecipesModel();
    }

    /**
     * Retrieve and render recipes.
     *
     * Retrieves the list of recipes from the RecipesModel, includes the corresponding view file,
     * and returns a JSON response with the rendered content.
     * If no recipes are found, a message indicating the response is displayed.
     *
     * @return void
     */
    public function recipesCont()
    {
        header('Content-Type: application/json');
        $recipes = $this->obj->getRecipesList();
        ob_start();

        require_once VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'recipes' . DS . "recipes-table.php";

        $output = ob_get_clean();

        if ($recipes) {
            echo json_encode(['message' => $output]);
            exit;
        } else {
            echo json_encode(['message' => '<h3 class="text-center text-secondary mt-5">No recipe found!!</h3>']);
            exit;
        }
    }

    /**
     * Create a new recipe.
     *
     * Handles the addition of a new recipe based on the data received through a *POST* request.
     * Validates and sanitizes input data, then calls the addRecipe method of the RecipesModel to add the recipe.
     * Display a JSON response indicating the success or failure of the operation.
     *
     * @return void
     */
    public function addNewRecipe()
    {

        $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_EMAIL);
        $calories = trim($_POST['calories'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        // Initialize data.............
        $data = [
            'name' => $name,
            'calories' => $calories,
            'image_url' => $image_url
        ];

        if ($this->obj->addRecipe($data)) {
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => "there is a problem to add"]);
            exit;
        }
    }
}
