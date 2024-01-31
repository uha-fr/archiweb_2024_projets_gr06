<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="/calorie-tracker-php/public/css/colors.css" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/calorie-tracker-php/public/css/global.css" />
  </head>
  <body>
    <!-- HEADER -->
    <?php
   include_once VIEWSDIR.DS.'components'.DS.'header.php';
    ?>
    <!-- BODY -->
    <div class="bg-bg" style="min-height: 100vh; padding-left: 180px">
      <div class="px-5 pt-5">
        <div class="container-fluid">
          <div class="row gap-4">
            <div class="col-lg-6" style="width: 500px;">
              <h5 class="fw-bold">Overview</h5>
              <div class="container bg-main rounded-3" style="height: 300px;">

              </div>
            </div>
            <div class="col-lg-6" style="max-width: 500px;">
              <h5 class="fw-bold">Timeline</h5>
              <div class="container bg-main rounded-3" style="height: 300px;">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
