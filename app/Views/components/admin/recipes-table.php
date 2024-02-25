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

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // Similar AJAX setup for delete and edit actions for recipes
  });
</script>
