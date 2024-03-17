<?php
if (!isset($_SESSION['id'])) {
    // Redirect to home.php
    header('Location: login');
    exit();
}


$period = $_GET["period"] ?? 7;
$duration = $_GET["duration"] ?? 30;
$periodJson = json_encode($period);
$durationJson = json_encode($duration);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Planning</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;,">
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/planning.css" />

</head>

<body>
    <!-- HEADER -->
    <?php

    include_once VIEWSDIR . DS . 'components' . DS . 'header.php';

    ?>
    <!-- BODY -->
    <script type="text/javascript">
        $(document).ready(function() {
            performAjaxRequest(
                "POST",
                "UserHavePlan",
                "",
                "",
                ""
            );
        });
    </script>
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
                <input type="text" class="form-control" name="plan-recipe-search" id="plan-recipe-search" placeholder="Search for recipe">

                <!-- Results -->
                <div id="plan-recipe-results" class="pt-4" style="max-height:350px; overflow:scroll;">

                </div>
            </div>
        </div>
        <!-- Planning Params -->

        <div style="min-height: 250px">
            <div id="userNotHavePlan" class="radio-container" style="background-color: var(--main-color); display: none;">
                <div class="radio-container" style="background-color: var(--main-color);">
                    <div class="form-group">
                        <div class="selector-label">
                            <h3 class="text-white">Period</h3>
                            <p>The number of days of the plan (repeats through the duration)</p>
                        </div>
                        <div class="selector width-per-item">
                            <a href="?period=7&duration=<?= $duration ?>" class="text-decoration-none selection <?= $period == 7 ? 'selected' : '' ?>">7 Days</a>
                            <a href="?period=14&duration=<?= $duration ?>" class="text-decoration-none selection <?= $period == 14 ? 'selected' : '' ?>">14
                                Days</a>
                            <a href="?period=30&duration=<?= $duration ?>" class="text-decoration-none selection <?= $period == 30 ? 'selected' : '' ?>">30
                                Days</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="selector-label">
                            <h3 class="text-white">Duration</h3>
                            <p>The number of total days of the plan</p>
                        </div>
                        <div class="selector width-per-item">
                            <a href="?period=<?= $period ?>&duration=7" class="text-decoration-none selection <?= $duration == 7 ? 'selected' : '' ?>">7
                                Days</a>
                            <a href="?period=<?= $period ?>&duration=14" class="text-decoration-none selection <?= $duration == 14 ? 'selected' : '' ?>">14
                                Days</a>
                            <a href="?period=<?= $period ?>&duration=30" class="text-decoration-none selection <?= $duration == 30 ? 'selected' : '' ?>">30
                                Days</a>
                            <a href="?period=<?= $period ?>&duration=60" class="text-decoration-none selection <?= $duration == 60 ? 'selected' : '' ?>">60
                                Days</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="selector-label">
                            <h3 class="text-white">Name of the Plan</h3>
                            <p>Add a name to your Plan</p>
                        </div>


                        <div class="selector width-per-item">
                            <form id="form-data" class="selector width-per-item">
                                <input type="text" name="plan-name" id="plan-name" class="bg-bg rounded p-1 px-2" style="width:300px; border:1px solid #ccc;" placeholder="Plan Name" required title="Please enter a plan name">
                                <input type="submit" name="add-plan-btn" id="add-plan-btn" class="rounded p-1 px-3  selection " style="margin-left: 10px;" value="Add Plan">
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div id="userHavePlan" class="radio-container" style="background-color: var(--main-color);display: none;">
                <div class="radio-container" style="background-color: var(--main-color);">
                    <div class="form-group text-center">
                        <div class="selector-label">
                            <h3 class="text-white">Name of the Plan:</h3>
                        </div>
                        <div class="selector width-per-item d-flex justify-content-center">
                            <h3 class="text-white"><strong id="planNameId"></strong></h3>
                        </div>
                        <div class="selector width-per-item d-flex justify-content-center">
                            <button type="submit" name="modify-plan-btn" id="modify-plan-btn" class="btn text-decoration-none selection rounded p-1 text-white">
                                <h3 class="text-white"><strong>Modify my plan</strong></h3>
                            </button>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="selector-label">
                            <h3 class="text-white">Period</h3>
                            <p>The number of days of the plan (repeats through the duration)</p>
                        </div>
                        <div class="selector width-per-item">
                            <a class="text-decoration-none selection" style="pointer-events: none;" id="periodValue"></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="selector-label">
                            <h3 class="text-white">Duration</h3>
                            <p>The number of total days of the plan</p>
                        </div>
                        <div class="selector width-per-item">
                            <a class="text-decoration-none selection" style="pointer-events: none;" id="durationValue"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <h4 class="mt-5 mb-3" style="padding-left: 20px;">Your Dietary Plan:</h4>
        <div class="bg-gray mx-3 rounded" id="dayPlan">
            <?php for ($day = 1; $day <= $period; $day++) : ?>
                <div>
                    <p class="p-3 text-white fw-bold" style="">Day
                        <?= $day ?>:
                    </p>
                    <div class="bg-dark-gray rounded p-2 d-flex flex-wrap flex-row gap-4 container-fluid" style="width: 95%">
                        <div class="rounded d-flex flex-wrap flex-row gap-4" style="width: fit-content" id="day-<?php echo $day ?>">

                        </div>
                        <a href="?period=<?= $period ?>&duration=<?= $duration ?>&selectedDay=<?= $day ?>#open-modal" class="d-flex flex-column justify-content-center bg-bg p-4 rounded text-decoration-none" style="min-height: 300px;width: fit-content; width: 250px">
                            <img style="width: 60px; height: 60px; object-fit: cover; border-radius: 100%; margin-left: 50%; transform: translateX(-50%);" src="<?= BASE_APP_DIR ?>/public/images/icons/plus.png" alt="Icon of a plus" />
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
        // HANDLE SEARCH
        $(document).ready(function() {
            // Debounced because its a search bar
            var debouncedSearch = debounce(function() {
                var inputValue = $('#plan-recipe-search').val();
                console.log(inputValue);

                performAjaxRequest(
                    "GET",
                    "planSearchForRecipe",
                    "&searchValue=" + inputValue,
                    "",
                    ""
                );

            }, 700); // 500 ms delay

            // Listening for changes in the input field
            $('#plan-recipe-search').on('input', function() {
                debouncedSearch();

            });
        });

        // HANDLE SELECT RECIPE:
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {

                var recipes = JSON.parse(localStorage.getItem('recipes')) || [];

                renderRecipes();

                // Function to save recipes to localStorage
                function saveRecipes() {
                    localStorage.setItem('recipes', JSON.stringify(recipes));
                }

                // Function to get the selected Day from the queryParams
                function getSelectedDay() {
                    var queryParams = new URLSearchParams(window.location.search);
                    return queryParams.get('selectedDay'); // Ensure 'selectedDay' is the correct query parameter name
                }

                // Function to handle rendering recipes to the correct div
                function renderRecipes() {
                    // Find all day divs and clear them
                    document.querySelectorAll('[id^="day-"]').forEach(dayDiv => {
                        dayDiv.innerHTML = ''; // Clear the div
                    });

                    // Go through each recipe and append it to the correct day div
                    recipes.forEach(recipe => {
                        var dayDiv = document.getElementById(`day-${recipe.date}`);
                        if (dayDiv) {

                            // Create a new element to hold the recipe information as a meal card
                            var recipeElement = document.createElement('div');
                            recipeElement.className =
                                'flex flex-column justify-content-start bg-bg p-4 rounded';
                            recipeElement.style =
                                'width: fit-content; max-width: 250px; min-width: 250px; align-items:center';
                            var imgPath;
                            if (recipe.image_url == null) {
                                imgPath = "https://www.allrecipes.com/thmb/5SdUVhHTMs-rta5sOblJESXThEE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11691-tomato-and-garlic-pasta-ddmfs-3x4-1-bf607984a23541f4ad936b33b22c9074.jpg";
                            } else {
                                imgPath = "<?= BASE_APP_DIR ?>/public/images/recipesImages/" + recipe.image_url;

                            }
                            recipeElement.innerHTML = `
                    <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;"
                    src="${imgPath}" />
                <div class="mt-4">
                    <p style="margin: 0;">
                        ${recipe.calories ?? "400"} Cal
                    </p>
                    <p class="fw-bold" style="font-size: 20px; padding-top: 0px">
                        ${recipe.name ?? "Default Recipe Name"}
                    </p>
                </div>
            `;

                            // Append the new element to the day div
                            dayDiv.appendChild(recipeElement);
                        }
                    });
                }

                function handleRecipeClick() {
                    var recipeId = this.dataset.recipeId;
                    var recipeName = this.dataset.recipeName;
                    var selectedDay = getSelectedDay();

                    var recipeData = {
                        id: recipeId,
                        name: recipeName,
                        date: selectedDay
                    };

                    // Add the clicked recipe's data to the recipes array
                    recipes.push(recipeData);

                    saveRecipes();

                    // After updating recipes array, re-render the recipes
                    renderRecipes();
                }

                // Attach event listener to the parent container or document
                document.addEventListener('click', function(event) {
                    var recipeItem = event.target.closest('.recipe-item');
                    if (recipeItem) {
                        handleRecipeClick.call(recipeItem);
                    }
                });
            }, 300); // 300 millisecondes 
        });
    </script>


    <script type="text/javascript">
        $("#add-plan-btn").click(function(e) {

            console.log("add plan btn clicked");
            if ($("#form-data")[0].checkValidity()) {
                e.preventDefault()
                //recupiration des valeur nécaissaire a transfirer
                var recipesData = JSON.parse(localStorage.getItem('recipes'));
                if (!recipesData) {
                    recipesData = [];
                }
                var period = <?php echo $periodJson; ?>;
                var duration = <?php echo $durationJson; ?>;
                var planName = $('#plan-name').val();
                console.log(period);
                console.log(duration);
                console.log(planName);
                if (recipesData.length > 0) {
                    // Convertir recipesData en JSON
                    var recipesDataJSON = JSON.stringify(recipesData);
                    var additionalData = "&recipesData=" + encodeURIComponent(recipesDataJSON) + "&period=" +
                        period +
                        "&duration=" + duration + "&planName=" + planName;
                    // Utilisation de la fonction performAjaxRequest pour envoyer les données au serveur
                    performAjaxRequest(
                        "POST",
                        "insertPlan",
                        additionalData,
                        "Plan added successfully!",
                        "",
                    );
                } else {
                    // Si le tableau est vide, imprimer un message indiquant qu'il n'y a aucun élément
                    Swal.fire({
                        title: `Recipe Plan Incomplete`,
                        icon: 'info',
                        html: `
              <div style="text-align: left;">
                <p>Please ensure that recipes are added to your plan</p>
              </div>`,
                    });
                }
            }
        });
    </script>

</body>

</html>
