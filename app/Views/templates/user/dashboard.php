<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
  <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/dashboard.css" />
</head>

<body>
  <!-- HEADER -->
  <?php
  include_once VIEWSDIR . DS . 'components' . DS . 'header.php';
  ?>
  <!-- BODY -->
  <div class="bg-bg" style="min-height: 100vh; padding-left: 180px">

    <!-- BELL NOTIFICATIONS ICON -->
    <div class="position-absolute" style="right: 20px; top: 20px">
      <div class="text-bg text-center d-flex align-items-center justify-content-center position-absolute"
        style="font-size: 16px; height:30px; width:30px; border-radius: 100%; left: -40%; top:40%; z-index:0; background-color: #252624;">
        0</div>
      <img src="<?= BASE_APP_DIR ?>/public/images/icons/bell.png" style="z-index:2;" alt="Image of a bell" />
    </div>

    <!-- REST OF THE PAGE CONTENT -->
    <div class="px-5 pt-5">
      <div class="container-fluid">
        <div class="row gap-4">
          <div class="col-lg-6" style="width: 500px;">
            <h5 class="fw-bold">Overview</h5>
            <div class="container bg-main rounded-3" style="height: 300px;position:relative;">
              <div class="project-box-wrapper">
                <div class="project-box" style="">
                  <div class="project-box-header">
                    <span>February 17, 2024</span>
                    <div class="more-wrapper">
                      <a href="<?= BASE_APP_DIR ?>/planning" class="project-btn-more">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-more-vertical">
                          <circle cx="12" cy="12" r="1" />
                          <circle cx="12" cy="5" r="1" />
                          <circle cx="12" cy="19" r="1" />
                        </svg>
                      </a>
                    </div>
                  </div>
                  <div class="project-box-content-header">
                    <p class="box-content-header">Keto Diet Plan</p>
                    <p class="box-content-subheader">Caloric Tracker</p>
                  </div>
                  <div class="box-progress-wrapper">
                    <p class="box-progress-header">Progress</p>
                    <div class="box-progress-bar">
                      <span class="box-progress" style="width: 60%; background-color: #ff942e"></span>
                    </div>
                    <p class="box-progress-percentage">60%</p>
                  </div>
                  <div class="project-box-footer">
                    <div></div>
                    <div class="days-left " style="color: #fff;">
                      2 Days Left
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6" style="max-width: 500px;">
            <h5 class="fw-bold">Timeline</h5>
            <div class="container bg-main rounded-3" style="height: 300px;">

            </div>
          </div>


          <!-- HERE WE PUT THE DAILY MEALS -->
          <div class="col-12" style="">
            <h5 class="fw-bold">Daily Tracking</h5>
            <div class="container-fluid bg-main rounded-3 pb-4" style="min-height: 300px;">
              <p class="text-bg fw-bold" style="margin-left: 28px; padding-top: 28px;">Today</p>
              <div class="bg-gray rounded p-3 d-flex flex-wrap flex-row gap-4 container-fluid" style="width: 100%">
                <?php
                include VIEWSDIR . DS . 'components' . DS . 'user' . DS . 'dashboard' . DS . 'meal.php';
                ?>

                <div class="d-flex flex-column justify-content-center bg-bg p-4 rounded"
                  style="width: fit-content; width: 250px">
                  <img
                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 100%; margin-left: 50%; transform: translateX(-50%);"
                    src="<?= BASE_APP_DIR ?>/public/images/icons/plus.png" alt="Icon of a plus" />
                  <p class="fw-bold text-main text-center" style="font-size: 20px; padding-top: 0px;">Add new Item</p>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>