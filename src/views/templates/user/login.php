<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../../public/css/colors.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../../public/css/global.css" />

  </head>
  <body>
    <!-- HEADER -->
    <?php
    include_once '../../components/header.php';

  

    ?>
    <!-- BODY -->
    <div class="w-full min-h-screen pl-[180px] bg-bg">
      <!-- Login Form-->
      <div class="w-full items-center flex-column flex min-h-screen pt-24">
        <h1 class="text-5xl font-bold">Login</h1>
        <form
          
          class="bg-gray w-[500px] rounded min-h-[400px] mt-14 p-8"
          id="form-data" 
          action=""
          method="post" 
          
        >

          <div class="flex flex-column mt-4">
            <label class="font-bold text-white">Email</label>
            <input
              type="email"
              name="email"
              placeholder="Ex:john.doe@gmail.com"
              class="py-3 px-4 rounded mt-2"
              required
            />
          </div>
          <div class="flex flex-column mt-4">
            <label  class="font-bold text-white">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password"
              class="py-3 px-4 rounded mt-2"
              required
            />
          </div>

          

          <div class="flex flex-column mt-4">
            <input type="submit" 
             class="py-3 px-4 bg-[#d6ff92] rounded w-full" 
             name="login" 
             id="login" 
             value="Login">
          </div>
          <a class="logo h-[66px] w-[66px] self-end" href="reset-password.php">
          Reset password
        <img src="" alt="" />
      </a>
        </form>
      </div>
    </div>



<script type="text/javascript">

$("#login").click(function(e){
    if($("#form-data")[0].checkValidity()){
        e.preventDefault();
        
        $.ajax({
            url: "../controllers/Users.php",
            type: "POST",
            data: $("#form-data").serialize() + "&action=login",
            dataType: 'json', // Expect JSON response
            success: function(response){
                if(response.success) {
                    Swal.fire({
                        title: 'User login successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'first-login.php'; // Redirect to home.php
                    });
                    $("#form-data")[0].reset(); // Reset form only on success
                } else {
                    Swal.fire({
                        title: 'Login failed!',
                        text: response.message, // Display the error message from the server
                        icon: 'error'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: 'AJAX error!',
                    text: 'Please try again. (' + textStatus + ')',
                    icon: 'error'
                });
            }
        });
    }
});
   
</script>
  </body>
</html>
