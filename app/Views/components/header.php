<header class="d-flex flex-column justify-content-between align-items-center bg-main position-fixed left-0 top-0" style="width: 180px; height: 100vh; padding: 80px 0;">
  <div>
    <!-- Logo -->
    <div class="logo">
      <img src="<?= BASE_APP_DIR ?>/public/images/logo.png" alt="" />
    </div>
    <!-- Nav -->
  </div>

  <!-- Disconnect / Connect -->
  <?php if (!isset($_SESSION['id'])) : ?>
    <div>
      <a class="logo" href="login">
        Login
        <img src="" alt="" />
      </a>
      <a class="logo" href="register">
        Register
        <img src="" alt="" />
      </a>
    </div>

  <?php else : ?>

    <div>
      <nav class="" style="padding-top: 15%">
        <ul class="d-flex flex-column align-items-center list-unstyled" style="gap: 5rem;">
          <li>
            <a href="dashboard"><img src="<?= BASE_APP_DIR ?>/public/images/icons/home.png" alt="" /></a>
          </li>
          <li>
            <a href="planning"><img src="<?= BASE_APP_DIR ?>/public/images/icons/calender.png" alt="" /></a>
          </li>
          <li>
            <a href="recipes-list"><img src="<?= BASE_APP_DIR ?>/public/images/icons/market.png" alt="" /></a>
          </li>
          <li>
            <a href="settings"><img src="<?= BASE_APP_DIR ?>/public/images/icons/user.png" alt="" /></a>
          </li>
          <?php if ($_SESSION['role'] === "Admin") : ?>
            <a href="dashboardAdmin"><img src="<?= BASE_APP_DIR ?>/public/images/icons/admin.png" alt="" /></a>
          <?php endif; ?>
          <?php if ($_SESSION['role'] === "Nutritionist") : ?>
            <a class="logo" href="nutritionist-dashboard"><img src="<?= BASE_APP_DIR ?>/public/images/icons/nutritionist.png" alt="Nutritionist" /></a>
          <?php endif; ?>

        </ul>
      </nav>
    </div>

    <a class="logo" href="">
      <img name="logout" id="logout" src="<?= BASE_APP_DIR ?>/public/images/icons/disconnect.png" alt="" />
    </a>
  <?php endif; ?>
</header>

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
<script type="text/javascript">
  $("#logout").click(function(e) {
    e.preventDefault();
    performAjaxRequest(
      "POST",
      "logout",
      "",
      "User logout successfully!"
    );
  });
</script>