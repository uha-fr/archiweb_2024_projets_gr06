<!-- SECURITY -->
<div class="container-fluid pt-4">
          <h4>Account Security</h4>
          <p>Update your email and password here.</p>
          <!-- FORM -->
          <form class="" id="form-data">
            <!-- EMAIL -->
            <label for="email" class="pt-2">Email:</label>
            <input
              type="email"
              class="form-control mt-2"
              aria-label="email"
              id="email"
              name="email"
              value="<?php echo $_SESSION['email'] ?>"
            />
            <!-- OLD PASSWORD -->
            <label for="old_password" class="pt-2">Old Password</label>
            <input
              type="password"
              class="form-control mt-2"
              aria-label="old_password"
              id="old_password"
              name="old_password"
            />

            <!-- New Password -->
            <label for="password" class="pt-4">New Password</label>
            <div class="input-group mt-2 flex-nowrap">
              <span class="input-group-text">Password</span>
              <input
                type="password"
                aria-label="password"
                class="form-control"
                id="password"
                name="new_password"
              />
              <span class="input-group-text">Repeat Password</span>
              <input
                type="password"
                aria-label="repeat_password"
                class="form-control"
                id="repeat_password"
                name="repeat_password"
              />
            </div>

            <!-- BUTTON SUBMIT -->
            <div class="d-grid gap-2 col-6 mt-4">
              <button class="btn btn-primary bg-main border-main" id="update-user-credentials-btn" type="submit">
                Submit
              </button>
            </div>
          </form>
        </div>

<script type="text/javascript">
$("#update-user-credentials-btn").click(function(e){
    if($("#form-data")[0].checkValidity()){
        e.preventDefault();

        var password = $("#password").val();
        var confirmPassword = $("#repeat_password").val();

        // Check if passwords match
        if(password !== confirmPassword) {
            Swal.fire({
                title: 'Update failed!',
                text: 'Passwords do not match.',
                icon: 'error'
            });
            return; // Don't submit the form data
        }
        performAjaxRequest(
          "POST",
          "update-user-credentials",
          "",
          "User password updated successfully!",
          ""
        );
        
    }
});
   
</script>

