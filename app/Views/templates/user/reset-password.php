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
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <script src="https://cdn.tailwindcss.com"></script>
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
  <div class="w-full min-h-screen pl-[180px] bg-bg">
    <!-- Login Form-->
    <div class="w-full items-center flex-column flex min-h-screen pt-24">
      <h1 class="text-5xl font-bold">New password Request</h1>
      <form class="bg-gray w-[500px] rounded min-h-[400px] mt-14 p-8" id="form-data" action="" method="POST">

        <div class="flex flex-column mt-4">
          <label class="font-bold text-white">Email</label>
          <input type="email" name="email" placeholder="Ex:john.doe@gmail.com" class="py-3 px-4 rounded mt-2" required />
        </div>
        <div class="flex flex-column mt-4">
          <input type="submit" class="py-3 px-4 bg-[#d6ff92] rounded w-full" name="resetPassword" id="resetPassword" value="Receive Email">
        </div>
      </form>

    </div>
  </div>


  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
  <script type="text/javascript">
    $("#resetPassword").click(function(e) {
      if ($("#form-data")[0].checkValidity()) {
        e.preventDefault();

        performAjaxRequest(
          "POST",
          "resetPassword",
          "",
          "New password Email sent successfully!",
          ""
        );
      }
    });
  </script>


</body>

</html>