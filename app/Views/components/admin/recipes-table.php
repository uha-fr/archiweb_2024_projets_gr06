<table>
  <thead>
    <tr>
      <th>Recipe</th>
      <th>Type</th>
      <th>Calories</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $row) : ?>
      <tr>
        <td>
          <?php
          if (!isset($row->image_url) || $row->image_url == null) {
            $row->image_url = 'https://cdn2.iconfinder.com/data/icons/picnic-filledoutline/64/FOOD_RECIPE-recipe-ingredients-ingredient-eduation-recipes-orange-books-cooking-512.png';
          } ?>
          <img src="<?= BASE_APP_DIR ?><?= htmlspecialchars($row->image_url) ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%;">
          <p><?= htmlspecialchars($row->name) ?></p>
        </td>
        <td><?= isset($row->type) && $row->type !== null ? htmlspecialchars($row->type) : "" ?></td>
        <td><?= htmlspecialchars($row->calories) ?></td>
        <td>
          <a href="#" title="View Details" class="text-success infoBtn" id="<?= $row->id ?>"><i class='bx bxs-book-open'></i></a>
          <a href="#" title="Edit" class="editBtn" id="<?= $row->id ?>"><i class='bx bxs-edit'></i></a>
          <a href="#" style="color: var(--danger)" class="delBtn" id="<?= $row->id ?>"><i class='bx bxs-trash'></i></a>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>

<!-- Add your modals and scripts here, similar to the users-table.php file -->
<!-- Recipe Details Modal -->
<div class="modal fade" id="recipeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="recipeDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recipeDetailsModalLabel">Recipe Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="recipeDetails">
        <!-- Recipe details will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Recipe Modal -->
<div class="modal fade" id="editRecipeModal" tabindex="-1" role="dialog" aria-labelledby="editRecipeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="editRecipeModalLabel">Edit Recipe</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body px-4">
        <form action="" method="post" id="recipe-form-data" enctype="multipart/form-data">
          <input type="hidden" id="edit_id" name="edit_id">
          <div class="form-group">
            <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Name" required>
          </div>
          <div class="form-group">
            <input type="number" name="edit_calories" id="edit_calories" class="form-control" placeholder="Calories" required>
          </div>
          <div class="form-group">
            <select name="edit_type" id="edit_type" class="form-control" required>
              <option value="">Select type</option>
              <option value="breakfast">breakfast</option>
              <option value="lunch">lunch</option>
              <option value="dinner">dinner</option>
              <option value="snack">snack</option>
            </select>
          </div>
          <div class="form-group">
            <select name="edit_visibility" class="form-control" required>
              <option value="visible">Visible</option>
              <option value="hidden">Hidden</option>
            </select>
          </div>
          <div class="form-group">
            <input type="hidden" name="edit_creator" class="form-control" placeholder="Creator ID" required value="<?= $_SESSION['id'] ?>">
          </div>
          <div class="form-group">
            <label for="edit_imageUpload">Choose recipe image</label>
            <input type="file" id="edit_imageUpload" name="edit_imageUpload" accept=".png, .jpg, .jpeg" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="saveEditedRecipe" id="saveEditedRecipe" value="Save Changes" class="btn btn-secondary btn-block">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>

<script type="text/javascript">
  $("#saveEditedRecipe").click(function(e) {
    e.preventDefault(); // Prevent default form submission
    if ($("#recipe-form-data")[0].checkValidity()) {
      var formData = new FormData($("#recipe-form-data")[0]); // Create FormData object from the form
      performAjaxWithImage('recipe-form-data', 'updateRecipe', 'Updated!', 'Recipe updated successfully.');
    }
  });
  $("body").on("click", ".editBtn", function(e) {
  e.preventDefault();
  var edit_id = $(this).attr('id');
  var additionalData = "&info_id=" + edit_id;

  performAjaxRequest("GET", "loadRecipeDetails", additionalData, "", "");

  $("#editRecipeModal").modal("show");
});
  $(document).ready(function() {



    //show user details
    $("body").on("click", ".infoBtn", function(e) {
      e.preventDefault();
      info_id = $(this).attr('id');
      var additionalData = "&info_id=" + info_id;

      performAjaxRequest("GET", "getRecipeDetails", additionalData, "", "");



    })
    $("body").on("click", ".delBtn", function(e) {
      e.preventDefault();
      var tr = $(this).closest('tr');
      var del_id = $(this).attr('id');

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.value) {
          performAjaxRequest("POST", "deleteRecipe", "&del_id=" + del_id, "Deleted!", "Recipe deleted successfully.");
        }
      });
    });


  });
</script>