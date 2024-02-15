<?php
if (isset($_SESSION['id'])) {
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
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />

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
      <h1 class="fw-bold">Login</h1>
      <form class="bg-gray rounded" style="width: 500px; min-height: 400px; margin-top: 40px; padding: 32px;" id="form-data" action="" method="post">

        <div class="d-flex flex-column mt-4">
          <label class="font-bold text-white">Email</label>
          <input type="email" name="email" placeholder="Ex:john.doe@gmail.com" class="py-3 px-4 rounded mt-2" style="border: 0;" required />
        </div>
        <div class="d-flex flex-column mt-4">
          <label class="font-bold text-white">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" class="py-3 px-4 rounded mt-2" style="border: 0;" required />
        </div>



        <div class="d-flex flex-column mt-4">
          <input type="submit" class="py-3 px-4 rounded w-full" style="background-color: #d6ff92; border: 0; margin-bottom: 12px;" name="login" id="login" value="Login">
        </div>
        <a class="logo self-end" href="reset-password">
          Reset password </br>
        </a>
        <a class="logo self-end" href="register">
          New User? Register here
        </a>
      </form>
    </div>
  </div>

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>

  <script type="text/javascript">
    $("#login").click(function(e) {
      console.log("dans login");
      if ($("#form-data")[0].checkValidity()) {
        e.preventDefault();
        performAjaxRequest(
          "POST",
          "login",
          "",
          "User login successfully!"
        );
      }
    });
  </script>

</body>

</html>