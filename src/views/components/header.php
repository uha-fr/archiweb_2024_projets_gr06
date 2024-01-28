<?php
session_start();
?>

<header
      class="d-flex flex-column justify-content-between align-items-center bg-main position-fixed left-0 top-0"
      style="width: 180px; height: 100vh; padding: 80px 0;"
    >
      <div>
        <!-- Logo -->
        <div class="logo">
          <img src="<?= BASE_APP_DIR ?>/public/images/logo.png" alt="" />
        </div>
        <!-- Nav -->
        <nav class="" style="padding-top: 130px">
          <ul class="d-flex flex-column align-items-center list-unstyled" style="gap: 5rem;">
            <li>
              <a href=""><img src="<?= BASE_APP_DIR ?>/public/images/icons/home.png" alt="" /></a>
            </li>
            <li>
              <a href=""><img src="<?= BASE_APP_DIR ?>/public/images/icons/calender.png" alt="" /></a>
            </li>
            <li>
              <a href=""><img src="<?= BASE_APP_DIR ?>/public/images/icons/market.png" alt="" /></a>
            </li>
            <li>
              <a href="/calorie-tracker-php/app/views/user/settings.php"><img src="<?= BASE_APP_DIR ?>/public/images/icons/user.png" alt="" /></a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- Disconnect / Connect -->
      <?php if(!isset($_SESSION['id'])) : ?>
        <a class="logo" href="login.php">
          Login
        <img src="" alt="" />
      </a>
      <a class="logo" href="register.php">
          S'inscrire
        <img src="" alt="" />
      </a>

        <?php else: ?>
      <a class="logo" href="">
        <img name="logout" id="logout" src="<?= BASE_APP_DIR ?>/public/images/icons/disconnect.png" alt="" />
      </a>
      <?php endif; ?>
    </header>

    <script type="text/javascript">

$("#logout").click(function(e){
  
        e.preventDefault();
        
        $.ajax({
            url: "/calorie-tracker-php/app/controllers/Users.php",
            type: "GET",
            data: "&q=logout",
            dataType: 'json', // Expect JSON response
            success: function(response){
                if(response.success) {
                    Swal.fire({
                        title: 'User logout successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = '/calorie-tracker-php/app/views/login.php'; // Redirect to home.php
                    });
                  }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: 'AJAX error!',
                    text: 'Please try again. (' + textStatus + ')',
                    icon: 'error'
                });
            }
        });
    
});
   
</script>