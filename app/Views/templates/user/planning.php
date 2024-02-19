<?php
if (!isset($_SESSION['id'])) {
    // Redirect to home.php
    header('Location: login');
    exit();
}


$period = $_GET["period"] ?? 7;
$duration = $_GET["duration"] ?? 30;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/planning.css" />

</head>

<body>
    <!-- HEADER -->
    <?php

    include_once VIEWSDIR . DS . 'components' . DS . 'header.php';

    ?>
    <!-- BODY -->
    <div class="container-fluid bg-bg pt-5" style="padding-left: 180px; min-height: 100vh;">
        <!-- MODAL -->
        <div id="open-modal" class="modal-window">
            <div>
                <a href="#" title="Close" class="modal-close">Close</a>
                <h1>Add Recipe</h1>
                <div>Add a recipe to your planning for this day. Search from global recipes, and your custom recipes.
                    you can add <a href="<?= BASE_APP_DIR ?>/recipes-list">custom recipes here</a></div>
                <br>


                <!-- Search bar -->
                <input type="text" class="form-control" name="plan-recipe-search" id="plan-recipe-search"
                    placeholder="Search for recipe">

                <!-- Results -->
                <div id="plan-recipe-results" class="pt-4" style="max-height:350px; overflow:scroll;">

                </div>
            </div>
        </div>
        <!-- Planning Params -->
        <div class="radio-container" style="background-color: var(--main-color);">
            <div class="form-group">
                <div class="selector-label">
                    <h3 class="text-white">Period</h3>
                    <p>The number of days of the plan (repeats through the duration)</p>
                </div>
                <div class="selector width-per-item">
                    <a href="?period=7&duration=<?= $duration ?>"
                        class="text-decoration-none selection <?= $period == 7 ? 'selected' : '' ?>">7 Days</a>
                    <a href="?period=14&duration=<?= $duration ?>"
                        class="text-decoration-none selection <?= $period == 14 ? 'selected' : '' ?>">14 Days</a>
                    <a href="?period=30&duration=<?= $duration ?>"
                        class="text-decoration-none selection <?= $period == 30 ? 'selected' : '' ?>">30 Days</a>
                </div>
            </div>

            <div class="form-group">
                <div class="selector-label">
                    <h3 class="text-white">Duration</h3>
                    <p>The number of total days of the plan</p>
                </div>
                <div class="selector">
                    <a href="?period=<?= $period ?>&duration=7"
                        class="text-decoration-none selection <?= $duration == 7 ? 'selected' : '' ?>">7 Days</a>
                    <a href="?period=<?= $period ?>&duration=14"
                        class="text-decoration-none selection <?= $duration == 14 ? 'selected' : '' ?>">14 Days</a>
                    <a href="?period=<?= $period ?>&duration=30"
                        class="text-decoration-none selection <?= $duration == 30 ? 'selected' : '' ?>">30 Days</a>
                    <a href="?period=<?= $period ?>&duration=60"
                        class="text-decoration-none selection <?= $duration == 60 ? 'selected' : '' ?>">60 Days</a>
                </div>
            </div>
        </div>

        <h4 class="mt-5 mb-3" style="padding-left: 20px;">Your Dietary Plan:</h4>
        <div class="bg-gray mx-3 rounded">
            <?php for ($day = 1; $day <= $period; $day++): ?>
                <div>
                    <p class="p-3 text-white fw-bold" style="">Day
                        <?php echo $day ?>:
                    </p>
                    <div class="bg-dark-gray rounded p-2 d-flex flex-wrap flex-row gap-4 container-fluid"
                        style="width: 95%">
                        <a href="#open-modal"
                            class="d-flex flex-column justify-content-center bg-bg p-4 rounded text-decoration-none"
                            style="min-height: 300px;width: fit-content; width: 250px">
                            <img style="width: 60px; height: 60px; object-fit: cover; border-radius: 100%; margin-left: 50%; transform: translateX(-50%);"
                                src="<?= BASE_APP_DIR ?>/public/images/icons/plus.png" alt="Icon of a plus" />
                            <p class="fw-bold text-main text-center" style="font-size: 20px; padding-top: 0px;">Add new Item
                            </p>
                        </a>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
    </div>

    <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            // Debounced because its a search bar
            var debouncedSearch = debounce(function () {
                var inputValue = $('#plan-recipe-search').val();

                performAjaxRequest(
                    "GET",
                    "planSearchForRecipe",
                    "&searchValue=" + inputValue,
                    "",
                    ""
                );

            }, 700); // 500 ms delay

            // Listening for changes in the input field
            $('#plan-recipe-search').on('input', function () {
                debouncedSearch();

            });
        });


    </script>

</body>

</html>