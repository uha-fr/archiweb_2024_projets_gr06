<?php
namespace Manger\Controller;

use Manger\Model\RecipesModel; // fonctionnel
 
class RecipesController{

    private $obj;

    public function __construct()
    {
        $this->obj= New RecipesModel();
    }

function recipesCont()
{
    
    $recipes = $this->obj->getRecipesList();
    require_once"Views/templates/user/recipes-list.php";
}
}