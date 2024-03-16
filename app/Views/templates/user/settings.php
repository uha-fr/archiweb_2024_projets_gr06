<?php
//app/Views/user/settings.php

require_once CLASSDIR . DS . 'Helpers/SessionHelper.php';


$tab = $_GET['tab'] ?? 'my-details'; // Default to 'my-details' if no tab is set


function generateTabLink($currentTab, $tabName, $label)
{
  $isActive = ($currentTab === $tabName) ? 'active-tab' : '';
  echo "<li><a class='nav-tab $isActive' href='?tab=$tabName'>$label</a></li>";
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
  <?php include_once VIEWSDIR . DS . 'components' . DS . 'header.php'; ?>
  <div class="" style="padding-left: 180px">
    <div class="container-fluid px-4 pt-5">
      <h1>Settings</h1>
      <!-- NAV -->
      <ul class="container-fluid d-flex list-unstyled gap-4 pt-2">
        <?php
        $tab = $_GET['tab'] ?? 'my-details';
        generateTabLink($tab, 'my-details', 'My details');
        generateTabLink($tab, 'security', 'Security');
        generateTabLink($tab, 'account-access', 'Account Access');
        generateTabLink($tab, 'notifications', 'Notifications');
        ?>
      </ul>

      <?php
      switch ($tab) {
        case 'my-details':
          include_once VIEWSDIR . DS . '/components/user/profile/my-details.php';
          break;
        case 'security':
          include_once VIEWSDIR . DS . '/components/user/profile/security.php';
          break;
        case 'account-access':
          include_once VIEWSDIR . DS . '/components/user/profile/account-access.php';
          break;
        case 'notifications':
          include_once VIEWSDIR . DS . '/components/user/profile/notifications.php';
          break;
        default:
          include_once VIEWSDIR . DS . '/components/user/profile/my-details.php';
          break;
      }
      ?>
    </div>
  </div>

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


</body>

</html>