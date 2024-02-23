<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>

<body>
  <!-- HEADER -->
  <?php
  include_once VIEWSDIR . DS . 'components' . DS . 'header.php';


  if (isset($_SESSION['age']) && $_SESSION['age'] !== null) {
    // Redirect to home.php
    header('Location: dashboard');
    exit();
  }
  ?>
  <!-- BODY -->
  <div class="w-full min-h-screen pl-[180px] bg-bg">
    <!-- First Login Form-->
    <div class="w-full items-center flex-column flex min-h-screen pt-24">
      <h1 class="text-5xl font-bold">Register formulaire</h1>
      <form class="bg-gray w-[500px] rounded min-h-[400px] mt-14 p-8" id="form-data" action="" method="post">

        <h1 class="text-3xl font-gray">Welcome,
          <?php echo explode(" ", $_SESSION['fullname'])[0]; ?>
        </h1>
        <br>
        <br>

        <!-- User id HIDDEN -->
        <input type="hidden" id="id" name="id" value="<?php echo $_SESSION['id'] ?>" />

        <div class="flex flex-column mt-4">
          <label class="font-bold text-white">Gender</label>
          <select class="py-3 px-4 rounded mt-2" id="gender" name="gender" required>
            <option value="">Choose...</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>



        <div class="flex flex-column">
          <label for="number" class="font-bold text-white">Age</label>
          <input type="number" name="age" placeholder="Age" class="py-3 px-4 rounded mt-2" required />
        </div>
        <br>
        <div class="flex flex-column">
          <label class="font-bold text-white">Goal</label>
          <select class="py-3 px-4 rounded mt-2" id="goal" name="goal" required>
            <option value="">Choose...</option>
            <option value="gain-weight-normal">Gain Weight</option>
            <option value="lose-weight-normal">Lose Weight</option>
            <option value="lose-weight-fast">Lose Weight Fast</option>
          </select>
        </div>

        <div class="flex flex-column mt-4">
          <label class="font-bold text-white">Height (cm)</label>
          <input type="number" name="height" step="0.01" placeholder="Height in cm" class="py-3 px-4 rounded mt-2" required />
        </div>
        <div class="flex flex-column mt-4">
          <label class="font-bold text-white">Weight (kg)</label>
          <input type="number" id="weight" name="weight" step="0.01" placeholder="Weight in kg" class="py-3 px-4 rounded mt-2" required />
        </div>


        <div class="flex flex-column mt-4">
          <input type="submit" class="py-3 px-4 bg-[#d6ff92] rounded w-full" name="firstLogin" id="firstLogin" value="Confirm">


        </div>
      </form>
    </div>
  </div>

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
  <script type="text/javascript">
    $("#firstLogin").click(function(e) {
      if ($("#form-data")[0].checkValidity()) {
        e.preventDefault();

        // Get user input
        var age = parseInt($('input[name="age"]').val());
        var height = parseFloat($('input[name="height"]').val());
        var weight = parseFloat($('input[name="weight"]').val());
        var goal = $('#goal').val();
        var gender = $('#gender').val();

        // Calculate Basal Metabolic Rate (BMR) using the Harris-Benedict equation
        var bmr = (gender === 'male') ?
          (88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age)) :
          (447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age));

        // Adjust BMR based on activity level (moderate activity level is assumed here)
        var dailyCalories = bmr * 1.55;

        // Adjust calorie intake based on the goal
        switch (goal) {
          case 'gain-weight-normal':
            dailyCalories += 500; // Increase by 500 for weight gain
            break;
          case 'lose-weight-normal':
            dailyCalories -= 500; // Decrease by 500 for weight loss
            break;
          case 'lose-weight-fast':
            dailyCalories -= 1000; // Decrease by 1000 for fast weight loss
            break;
        }

        var formData = $("#form-data").serialize() + "&action=first-login&dailyCalories=" + dailyCalories.toFixed(2);

        // Swal to confirm user information
        Swal.fire({
          title: '<strong>Confirm Your Details</strong>',
          icon: 'info',
          html: `<div style="text-align: left;">
                    <p><b>Gender:</b> ${gender}</p>
                    <p><b>Age:</b> ${age} years</p>
                    <p><b>Height:</b> ${height} cm</p>
                    <p><b>Weight:</b> ${weight} kg</p>
                    <p><b>Estimated Daily Calorie Needs:</b> ${dailyCalories.toFixed(2)} calories</p>
                </div>`,
          showCancelButton: true,
          confirmButtonText: 'Confirm Details',
          cancelButtonText: 'Review Information',
          buttonsStyling: true,
          customClass: {
            confirmButton: 'swal-confirm-button',
            cancelButton: 'swal-cancel-button'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // AJAX call if user confirms

            performAjaxRequest(
              "POST",
              "first-login",
              "&dailyCalories=" + dailyCalories.toFixed(2),
              "Profile Created Successfully!"
            );

          }
        });
      }
    });
  </script>



</body>

</html>