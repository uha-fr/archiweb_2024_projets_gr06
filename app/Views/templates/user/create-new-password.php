<?php
$rootPath = ROOT;
require_once $rootPath . '/Config/Globals.php'
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="<?=BASE_APP_DIR ?>/public/css/colors.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


  </head>
  <body>

  <?php
  if(empty($_GET['selector']) || empty($_GET['validator'])){
    echo ' Could not validate your request' ;

  } else {
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    if(ctype_xdigit($selector) && ctype_xdigit($validator)) { ?>
    <!-- HEADER -->
    <?php
   include_once VIEWSDIR.DS.'components'.DS.'header.php';
    ?>
    <!-- BODY -->
    <div class="w-full min-h-screen pl-[180px] bg-bg">
      <!-- Login Form-->
      <div class="w-full items-center flex-column flex min-h-screen pt-24">
        <h1 class="text-5xl font-bold">Create new password</h1>
        <form
          
          class="bg-gray w-[500px] rounded min-h-[400px] mt-14 p-8"
          id="form-data" 
          action=""
          method="post" 
          
        >

        <input type="hidden" name="selector" value="<?php echo $selector ?>" />
        <input type="hidden" name="validator" value="<?php echo $validator ?>" />

        <div class="flex flex-column mt-4">
            <label  class="font-bold text-white">New Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="New Password"
              class="py-3 px-4 rounded mt-2"
              required
            />
          </div>
          <div class="flex flex-column mt-4">
            <label  class="font-bold text-white"
              >Repeat Password</label
            >
            <input
              type="password"
              id="confPassword"
              name="confPassword"
              placeholder="Repeat New Password"
              class="py-3 px-4 rounded mt-2"
              required
            />
          </div>
          <div class="flex flex-column mt-4">
            <input type="submit" 
             class="py-3 px-4 bg-[#d6ff92] rounded w-full" 
             name="newPassword" 
             id="newPassword" 
             value="Confirm new Email">
          </div>
        </form>
        
      </div>
    </div>

   

  </body>
</html>

<?php
    }else {
        echo 'Could not validate your request!';
    } 
}
    ?>
