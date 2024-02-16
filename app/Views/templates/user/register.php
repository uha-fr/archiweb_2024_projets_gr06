<?php
if (isset($_SESSION['id']) ) {
  // Redirect to home.php
  header('Location: dashboard');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>

<body>
  <!-- HEADER -->
  <?php
  include_once VIEWSDIR . DS . 'components' . DS . 'header.php';
  ?>
  <!-- BODY -->
  <div class="container-fluid bg-bg" style="padding-left: 180px; min-height: 100vh;">
    <!-- Login Form-->
    <div class="container-fluid align-items-center flex-column d-flex" style="min-height: 100vh; padding-top: 140px;">
      <h1 class="fw-bold">Register</h1>
      <form class="bg-gray rounded" style="width: 500px; min-height: 400px; margin-top: 40px; padding: 32px;" id="form-data" action="" method="post">

        <div class="d-flex flex-column">
          <label for="fullname" class="font-bold text-white">Full Name</label>
          <input type="text" name="fullname" placeholder="Ex: John Doe" class="py-3 px-4 rounded mt-2" style="border:0;" required />
        </div>

        <div class="d-flex flex-column mt-4">
          <label class="font-bold text-white">Email</label>
          <input type="email" name="email" placeholder="Ex:john.doe@gmail.com" class="py-3 px-4 rounded mt-2" style="border:0;" required />
        </div>
        <div class="d-flex flex-column mt-4">
          <label class="font-bold text-white">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" class="py-3 px-4 rounded mt-2" style="border:0;" required />
        </div>
        <div class="d-flex flex-column mt-4">
          <label class="font-bold text-white">Repeat Password</label>
          <input type="password" id="confPassword" name="confPassword" placeholder="Repeat Password" class="py-3 px-4 rounded mt-2" style="border:0;" required />
        </div>

        <div class="d-flex flex-column mt-4">
          <input type="submit" class="py-3 px-4 rounded w-full" style="background-color: #d6ff92; border: 0; margin-bottom: 12px;" name="register" id="register" value="Register">


        </div>
      </form>
    </div>
  </div>

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>

  <script type="text/javascript">
    $("#register").click(function(e) {
      console.log("dans register");
      if ($("#form-data")[0].checkValidity()) {
        e.preventDefault();

        var password = $("#password").val();
        var confirmPassword = $("#confPassword").val();

        // Check if passwords match
        if (password !== confirmPassword) {
          Swal.fire({
            title: 'Registration failed!',
            text: 'Passwords do not match.',
            icon: 'error'
          });
          return; // Don't submit the form data
        }

        performAjaxRequest(
          "POST",
          "register",
          "",
          "User added successfully!",
          ""
        );
      }
    });
  </script>

</body>

</html>