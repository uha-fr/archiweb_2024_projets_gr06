<?php


if ($_SESSION['role'] != "Admin") {
  header('Location: dashboard'); // Redirect to dashboard
  exit();
}

$tab = $_GET['tab'] ?? 'dashboardAdmin';

/**
 * Generate a tab link for a navigation menu.
 *
 * This function generates an HTML list item (<li>) representing a tab link for a navigation menu.
 *
 * @param  mixed $currentTab
 * @param  mixed $tabName
 * @param  mixed $label
 * @param  mixed $iconClass
 * @return void
 */
function generateTabLink($currentTab, $tabName, $label, $iconClass)
{
  $isActive = ($currentTab === $tabName) ? 'active' : '';
  echo "<li class='$isActive' ><a  href='?tab=$tabName'><i class='$iconClass'></i>$label</a></li>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin dashboard</title>

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/adminDashboardStyle.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
  <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
</head>

<body>




  <!-- Sidebar -->
  <div class="sidebar" style="display:flex; flex-direction:column; justify-content:space-around;">
    <div>
      <!-- Logo -->
      <div class="logo" style="margin-left: 80px;">
        <a href="dashboard">
          <img src="<?= BASE_APP_DIR ?>/public/images/logo.png" alt="" />
        </a>
      </div>
      <!--  <ul class="side-menu">
    <li class=""><a href="?section=dashboardAdmin"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
    <li class=""><a href="?section=users"><i class='bx bx-group'></i>Users list</a></li>
    <li class="><a href="?section=recipes"><i class='bx bx-analyse'></i>Recipes list</a></li>
    
    <li><a href="#"><i class='bx bx-message-square-dots'></i>Tickets</a></li>
    <li><a href="#"><i class='bx bx-group'></i>Users</a></li>
    <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>
  </ul>-->
      <ul class="side-menu">
        <?php
        $tab = $_GET['tab'] ?? 'dashboardAdmin'; // Default to 'dashboardAdmin' if no tab is set
        generateTabLink($tab, 'dashboardAdmin', 'Dashboard', 'bx bxs-dashboard');
        generateTabLink($tab, 'usersList', 'Users list', 'bx bx-group');
        generateTabLink($tab, 'recipesList', 'Recipes list', 'bx bx-analyse');
        ?>
      </ul>

    </div>

    <ul class="side-menu">
      <li>
        <a href="dashboard" class="logout">
          <i class='bx bx-log-out-circle'></i>
          Logout
        </a>
      </li>
    </ul>
  </div>
  <!-- End of Sidebar -->

  <!-- Main Content -->
  <div class="content">
    <!-- Navbar -->
    <nav>
      <i class='bx bx-menu'></i>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search...">
          <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
        </div>
      </form>
      <input type="checkbox" id="theme-toggle" hidden>
      <label for="theme-toggle" class="theme-toggle"></label>
      <!--  <a href="#" class="notif">
      <i class='bx bx-bell'></i>
      <span class="count">12</span>
    </a>-->
    </nav>
    <!-- End of Navbar -->
    <?php
    switch ($tab) {
      case 'usersList':
        include_once VIEWSDIR . DS . '/components/admin/usersList.php';
        break;
      case 'recipesList':
        include_once VIEWSDIR . DS . '/components/admin/recipesList.php';
        break;
      default: // alos case 'dashboardAdmin'
        include_once VIEWSDIR . DS . '/components/admin/mainDashboard.php';
        break;
    }

    ?>


  </div>
  <!-- End of Main Content -->


  <!-- Correct Order and Single Version of jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

  <!-- Bootstrap and Other Dependencies -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="<?= BASE_APP_DIR ?>/public/js/adminDashboard.js"></script>

</body>

</html>