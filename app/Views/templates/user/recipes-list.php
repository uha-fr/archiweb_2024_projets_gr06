<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recipes List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="<?= BASE_APP_DIR ?>/public/js/recipes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- HEADER -->
    <?php
    include_once VIEWSDIR . DS . 'components' . DS . 'header.php';
    ?>
    <div class="w-full min-h-screen pl-[180px] bg-bg">
        <!-- Recipes Form-->
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col">
                        <h1 class="text-5xl font-bold" style="margin: 12px;">Recipes list</h1>
                    </div>
                    <div class="col">
                        <button class="btn btn-success btn-lg float-right" style="background-color: #678e48; border: 0; margin: 12px;" data-toggle="modal" data-target="#addModel" onclick="toggleIframe()">
                            <span class="me-2" style="font-size: 1.2em;">Add New Recipe</span>
                            <i class="fas fa-plus-circle fa-lg" style="font-size: 1.2em;"></i>
                        </button>
                    </div>
                </div>
                <!-- iframe à cacher/afficher -->
                <iframe id="myIframe" src="add-recipe" height="700" class="hidden"></iframe>
                <div class="row">
                    <div class="container-fluid bg-main rounded-3 pb-4 d-flex justify-content-center align-items-center p-4"" style=" min-height: 300px;">
                        <div id="RecipeList"></div>
                    </div>
                </div>
            </div>
        </div>
        </hr>
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
