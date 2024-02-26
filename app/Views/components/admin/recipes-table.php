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
      <img src="<?= BASE_APP_DIR ?><?= htmlspecialchars($row->image_url) ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%;">
      <p><?= htmlspecialchars($row->name) ?></p>
    </td>
    <td><?= htmlspecialchars($row->type) ?></td>
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


<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
<script type="text/javascript">
  $(document).ready(function() {





    //show user details
    $("body").on("click", ".infoBtn", function(e) {
      e.preventDefault();
      info_id = $(this).attr('id');
      var additionalData = "&info_id=" + info_id;

      performAjaxRequest("GET", "getRecipeDetails", additionalData, "", "");



    })
    



  });
</script>
