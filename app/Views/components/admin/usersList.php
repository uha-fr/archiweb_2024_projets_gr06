<style>
  .profile-card {
    text-align: center;
    font-family: Arial, sans-serif;
    border-radius: 8px;
    padding: 20px;
    max-width: 200px;
    margin: auto;
  }

  .profile-image {
    background-color: #e0e0e0;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    margin: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .profile-name {
    margin-top: 8px;
    font-size: 18px;
    color: #333;
  }

  .profile-description {
    font-size: 14px;
    color: #666;
  }
</style>

<main>
  <div class="header">
    <div class="left">
      <h1>Users list</h1>

    </div>
    <a href="#" class="report" data-toggle="modal" data-target="#addModel">
      <i class='bx bxs-user-plus '></i>
      <span>Add user</span>
    </a>

  </div>

  <!-- End of Insights -->

  <div class="bottom-data">
    <!-- Orders -->
    <div class="orders">

      <div id="showUser">


      </div>

    </div>
    <!-- End of Orders -->


    <!-- End of Reminders -->
  </div>
</main>


<!-- Add new user -->
<div class="modal fade" id="addModel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add new user</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body px-4">
        <form action="" method="post" id="form-data" enctype="multipart/form-data">
          <div class="profile-card">


            <input type="file" id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" style="display: none;" />
            <label for="imageUpload">
              <img src="<?= BASE_APP_DIR ?>/public/images/default-user.png" alt="Profile Image" class="profile-image" id="profileImage" style="text-align: center;" />
            </label>
          </div>


          <div class="form-group">
            <input type="text" name="fullname" class="form-control" placeholder="Full name" required />
          </div>

          <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control" required />
          </div>
          <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control" required />
          </div>
          <div class="form-group">
            <input type="password" id="confPassword" name="confPassword" placeholder="Repeat Password" class="form-control" required />
          </div>

          <div class="form-group">
            <input type="submit" name="addNewUser" id="addNewUser" value="Add user" class="btn btn-secondary btn-block">
          </div>

        </form>
      </div>



    </div>
  </div>
</div>
<!-- AJAX response will be inserted here -->

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


<script type="text/javascript">
  console.log("Document ready");
  $(document).ready(function() {
    console.log("Making AJAX call");
    performAjaxRequest("GET", "getAllUsers", "", "", "");
  });


  document.getElementById('imageUpload').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var output = document.getElementById('profileImage');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  });

  $("#addNewUser").click(function(e) {
    e.preventDefault(); // Prevent default form submission

    if ($("#form-data")[0].checkValidity()) {
      var formData = new FormData($("#form-data")[0]); // Create FormData object from the form

      var password = $("#password").val();
      var confirmPassword = $("#confPassword").val();

      var fileName = $('#imageUpload').val().split('\\').pop(); // Gets the file name

      // Check if passwords match
      if (password !== confirmPassword) {
        Swal.fire({
          title: 'Registration failed!',
          text: 'Passwords do not match.',
          icon: 'error'
        });
        return;
      }

      performAjaxWithImage('form-data', 'addNewUser', 'User added successfully!', 'The user has been successfully added.');

    }
  });
</script>