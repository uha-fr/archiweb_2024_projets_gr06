<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Not Found 404</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= BASE_APP_DIR ?>/public/css/404-error.css" rel="stylesheet">
  <style>
 html, body {
  height: 100%;
  margin: 0;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.section {
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.container {
  width: 100%; /* or max-width for larger views */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}


  </style>

</head>

<body>

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center" >
        <h1>404</h1>
        <h2>The page you are looking for doesn't exist.</h2>
       <div> <a class="btn" href="login">Back to home</a></div>
        <img src="<?= BASE_APP_DIR ?>/public/images/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
      
      </section>

    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>