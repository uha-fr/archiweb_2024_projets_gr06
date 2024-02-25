<table>
  <thead>
    <tr>
      <th>User</th>
      <th>Email</th>
      <th>Role</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($data as $row) : ?>
      <tr>
        <td>
          <img src="<?= BASE_APP_DIR ?><?= htmlspecialchars($row->img) ?>" alt="">
          <p><?= htmlspecialchars($row->fullname) ?></p>
        </td>
        <td><?= htmlspecialchars($row->email) ?></td>
        <td><?= htmlspecialchars($row->role) ?></td>
        <td>
          <?php if ($row->active == 1) : ?>
            <span class="status completed">Active</span>
          <?php elseif ($row->active == 2) : ?>
            <span class="status pending">Demande en cours</span>
          <?php else : ?>
            <span class="status deleted">Inactive</span>
          <?php endif; ?>
        </td>
        <td>
          <a href="#" title="View Details" class="text-success infoBtn" id="<?= $row->id ?>"><i class='bx bxs-user-detail'></i></a>
          <a href=""><i class='bx bxs-edit'></i></a>
          <a href="" style="color: var(--danger)" class="delBtn" id="<?= $row->id ?>"><i class='bx bxs-trash'></i></a>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>

</table>

<!-- Update user modal -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit user</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body px-4">
        <form action="" method="post" id="edit-form-data">

          <input type="hidden" name="id" id="id" Required>

          <div class="form-group">
            <input type="text" name="fname" class="form-control" id="fname" Required>
          </div>

          <div class="form-group">
            <input type="text" name="email" class="form-control" id="email" required>
          </div>
          <div class="form-group">
            <input type="submit" name="update" id="update" value="Update user" class="btn btn-primary btn-block">
          </div>

        </form>
      </div>



    </div>
  </div>
</div>
<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
<script type="text/javascript">
  $(document).ready(function() {



    // Updated delete request using performAjaxRequest
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
          performAjaxRequest("POST", "deleteUser", "&del_id=" + del_id, "Deleted!", "User deleted successfully.");
        }
      });
    });


    //show user details
    $("body").on("click", ".infoBtn", function(e) {
      e.preventDefault();
      info_id = $(this).attr('id');
      var additionalData = "&info_id=" + info_id;

      performAjaxRequest("GET", "getUserDetails", additionalData, "", "");


    })

  });
</script>