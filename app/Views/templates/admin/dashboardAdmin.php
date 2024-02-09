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
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/global.css" />
  

  <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

  

</head>

<body>
  

     

             <!-- Sidebar -->
 <div class="sidebar" style="display:flex; flex-direction:column; justify-content:space-around;" >
  <div>
    <!-- Logo -->
    <div class="logo" style="margin-left: 80px;">
      <img src="<?= BASE_APP_DIR ?>/public/images/logo.png" alt="" />
    </div>
    <ul class="side-menu">
    <li><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
    <li><a href="#"><i class='bx bx-group'></i>Users list</a></li>
    <li class="active"><a href="#"><i class='bx bx-analyse'></i>Recipes list</a></li>
    
   <!-- <li><a href="#"><i class='bx bx-message-square-dots'></i>Tickets</a></li>
    <li><a href="#"><i class='bx bx-group'></i>Users</a></li>
    <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>-->
  </ul>
  </div>
 
  <ul class="side-menu" >
    <li>
      <a href="#" class="logout">
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
  
  <main>
    <div class="header">
      <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
          <li><a href="#">Analytics</a></li>
          /
          <li><a href="#" class="active">Shop</a></li>
        </ul>
      </div>
      <a href="#" class="report">
        <i class='bx bx-cloud-download'></i>
        <span>Download CSV</span>
      </a>
    </div>

    <!-- Insights -->
    <ul class="insights">
      <li>
        <i class='bx bx-user'></i>
        <span class="info">
          <h3 id="usersNumber">0</h3>
          <p>Number users</p>
        </span>
      </li>
      <li>
        <i class='bx bx-show-alt'></i>
        <span class="info">
          <h3>3,944</h3>
          <p>Site Visit</p>
        </span>
      </li>
      <li>
        <i class='bx bx-note'></i>
        <span class="info">
          <h3>14,721</h3>
          <p>Searches</p>
        </span>
      </li>
      <li>
        <i class='bx bx-dollar-circle'></i>
        <span class="info">
          <h3>$6,742</h3>
          <p>Total Sales</p>
        </span>
      </li>
    </ul>
    <!-- End of Insights -->

    <div class="bottom-data">
      <!-- Orders -->
      <div class="orders">
        <div class="header">
          <i class='bx bx-receipt'></i>
          <h3>Recent Orders</h3>
          <i class='bx bx-filter'></i>
          <i class='bx bx-search'></i>
        </div>
        <table>
          <thead>
            <tr>
              <th>User</th>
              <th>Order Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <img src="<?= BASE_APP_DIR ?>/public/images/profile-1.jpg" alt="">
                <p>John Doe</p>
              </td>
              <td>14-08-2023</td>
              <td><span class="status completed">Completed</span></td>
            </tr>
            <tr>
              <td>
                <img src="<?= BASE_APP_DIR ?>/public/images/profile-1.jpg" alt="">
                <p>John Doe</p>
              </td>
              <td>14-08-2023</td>
              <td><span class="status pending">Processing</span></td>
            </tr>
            <tr>
              <td>
                <img src="<?= BASE_APP_DIR ?>/public/images/profile-1.jpg" alt="">
                <p>John Doe</p>
              </td>
              <td>14-08-2023</td>
              <td><span class="status deleted">Deleted</span></td>
            </tr>
            <!-- More rows -->
          </tbody>
        </table>
      </div>
      <!-- End of Orders -->

      <!-- Reminders -->
      <div class="reminders">
        <div class="header">
          <i class='bx bx-note'></i>
          <h3>Remiders</h3>
          <i class='bx bx-filter'></i>
          <i class='bx bx-plus'></i>
        </div>
        <ul class="task-list">
          <li class="completed">
            <div class="task-title">
              <i class='bx bx-check-circle'></i>
              <p>Start Our Meeting</p>
            </div>
            <i class='bx bx-dots-vertical-rounded'></i>
          </li>
          <!-- More tasks -->
        </ul>
      </div>
      <!-- End of Reminders -->
    </div>
  </main>
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

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


  <script type="text/javascript">
     $(document).ready(function(){

      performAjaxRequest(
          "GET",
          "countRegularUsers",
          "",
          "",
          ""
        );
     });
    
  </script>


</body>

</html>