<style>
  .recipe-card {
    text-align: center;
    font-family: Arial, sans-serif;
    border-radius: 8px;
    padding: 20px;
    max-width: 200px;
    margin: 10px auto;
  }

  .recipe-image {
    background-color: #e0e0e0;
    border-radius: 8px;
    width: 100%;
    height: 120px;
    margin: auto;
    display: block;
  }

  .recipe-title {
    margin-top: 8px;
    font-size: 18px;
    color: #333;
  }

  .recipe-description {
    font-size: 14px;
    color: #666;
  }
</style>

<main>
  <div class="header">
    <div class="left">
      <h1>Recipe list</h1>
    </div>
    <a href="#" class="report" data-toggle="modal" data-target="#addRecipeModal">
      <i class='bx bxs-book-add'></i>
      <span>Add recipe</span>
    </a>
  </div>

  <div class="bottom-data">
    <div class="orders">
      <div id="showRecipes">
        <!-- Recipes will be loaded here dynamically -->
      </div>
    </div>
  </div>
</main>

<!-- Add new recipe -->
<div class="modal fade" id="addRecipeModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add new recipe</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body px-4">
        <form action="" method="post" id="recipe-form-data" enctype="multipart/form-data">
          <div class="form-group">
            <input type="text" name="recipeName" class="form-control" placeholder="Recipe name" required />
          </div>
          <div class="form-group">
            <textarea name="recipeDescription" placeholder="Recipe description" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="recipeImageUpload">Choose recipe image</label>
            <input type="file" id="recipeImageUpload" name="recipeImageUpload" accept=".png, .jpg, .jpeg" class="form-control" />
          </div>
          <div class="form-group">
            <input type="submit" name="addNewRecipe" id="addNewRecipe" value="Add recipe" class="btn btn-secondary btn-block" >
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


<script type="text/javascript">
 console.log("Document ready");
  $(document).ready(function() {
    console.log("Making AJAX call");
    performAjaxRequest("GET", "getAllRecipes", "", "", "");
  });

</script>
