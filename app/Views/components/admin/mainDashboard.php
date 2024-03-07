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
      <i class='bx bxs-face'></i>
      <span class="info">
        <h3 id="nutritionistNumber">0</h3>
        <p>Number nutritionist</p>
      </span>
    </li>
    <li>
      <i class='bx bxs-pizza'></i>
      <span class="info">
        <h3 id="countRecipes">0</h3>
        <p>Number recipes</p>
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

<script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


<script type="text/javascript">
  $(document).ready(function() {

    performAjaxRequest(
      "GET",
      "countRegularUsers",
      "",
      "",
      ""
    );
    performAjaxRequest(
      "GET",
      "countNutritionistUsers",
      "",
      "",
      ""
    );
    performAjaxRequest(
      "GET",
      "countRecipes",
      "",
      "",
      ""
    );
  });
</script>