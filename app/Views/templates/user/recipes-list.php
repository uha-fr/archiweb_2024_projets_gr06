<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipes List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?> /public/css/colors.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?> /public/css/global.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
</head>

<body>
    <!-- HEADER -->
     include_once VIEWSDIR . DS . 'components' . DS . 'header.php';
    <?php
    
    ?>
    <div class="w-full min-h-screen pl-[180px] bg-bg">
        <!-- Recipes Form-->
        <div class="w-full items-center flex-column flex min-h-screen pt-24">
            <h1 class="text-5xl font-bold">Recipes</h1>
            <div class="container">
                <div class="row">
                    <div class="col lg 12">
                        <h1 class="text-5xl font-bold"> Recipes list</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary m1 float-right " data-toggle="modal" data-target="#addModel">Add new recipes</button>
                    </div>
                </div>
                <hr class="my-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive" id="RecipeList">
                        </div>
                    </div>
                </div>
                </hr>
            </div>
        </div>
    </div>
    </div>
    </div>
   
    <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            performAjaxRequest(
                "POST",
                "showAllRecipes",
                "",
                "",
                ""
            );
        });
    </script>
</body>
</html>
