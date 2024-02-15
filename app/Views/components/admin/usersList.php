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

      
      <!-- End of Reminders -->
    </div>
  </main>