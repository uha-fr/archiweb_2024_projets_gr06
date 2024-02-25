<?php


if ($_SESSION['role'] != "Nutritionist") {
  header('Location: dashboard'); // Redirect to dashboard
  exit();
}


$tab = $_GET['tab'] ?? 'nutritionist-dashboard';

function generateTabLink($currentTab, $tabName, $label, $svgContent)
{
  $isActive = ($currentTab === $tabName) ? 'active' : '';
  $url = htmlspecialchars("?tab=$tabName"); // Ensuring the URL is properly escaped
  $activeClass = $isActive ? 'app-sidebar-link active' : 'app-sidebar-link';

  echo "<a href='$url' class='$activeClass'>";
  echo $svgContent; // This is your SVG icon
  // You may want to show a label next to the icon
  echo "</a>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin dashboard</title>

  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/nutritionist-dashboard.css">




</head>

<body>
  <div class="app-container">
    <div class="app-header">
      <div class="app-header-left">
        <div class="logo">
          <img src="<?= BASE_APP_DIR ?>/public/images/logo.png" alt="" />
        </div>
        <p class="app-name">Dashboard</p>
        <div class="search-wrapper">
          <input class="search-input" type="text" placeholder="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewBox="0 0 24 24">
            <defs></defs>
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
          </svg>
        </div>
      </div>
      <div class="app-header-right">
        <button class="mode-switch" title="Switch Theme">
          <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
            <defs></defs>
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
          </svg>
        </button>
        <button class="add-btn" title="Add New Project">
          <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>
        </button>
        <button class="notification-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
          </svg>
        </button>
        <button class="profile-btn">
          <img src="https://assets.codepen.io/3306515/IMG_2025.jpg" />
          <span>Aybüke C.</span>
        </button>
      </div>
      <button class="messages-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
          <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
        </svg>
      </button>
    </div>
    <div class="app-content">

      <div class="app-sidebar">
        <?php
        // Define your SVG content for each tab
        $mainSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" /></svg>'; // SVG for Dashboard
        $usersListSVG = '<svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-pie-chart" viewBox="0 0 24 24">
            <defs />
            <path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z" />
          </svg>'; // SVG for Users List
        $recipesListSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" /></svg>'; // SVG for Recipes List

        // Generate links with SVG icons
        generateTabLink($tab, 'nutritionist-dashboard', 'Dashboard', $mainSVG);
        generateTabLink($tab, 'client-list', 'Client List', $usersListSVG);
        generateTabLink($tab, 'recipesList', 'Recipes List', $recipesListSVG);
        ?>
      </div>


      <?php
      switch ($tab) {
        case 'nutritionist-dashboard':
          include_once VIEWSDIR . DS . '/components/nutritionist/main-dashboard.php';
          break;
        case 'client-list':
          include_once VIEWSDIR . DS . '/components/nutritionist/client-list.php';
          break;
        case 'recipesList':
          include_once VIEWSDIR . DS . 'components/admin/recipesList.php';
          break;
        default:
          include_once VIEWSDIR . DS . '/components/nutritionist/main-dashboard.php';
          break;
      }

      ?>

    </div>


  </div>
  <script src="<?= BASE_APP_DIR ?>/public/js/nutritionist-dashboard.js"></script>


</body>