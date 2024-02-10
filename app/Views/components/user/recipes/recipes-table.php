<?php
// Assuming $recipes is an array containing the items retrieved from the database

// Divide recipes into groups of 5
$recipeGroups = array_chunk($recipes, 4);

// Open the container div for the list
echo '<div class="list-container">';

// Loop through each group
foreach ($recipeGroups as $group) {
    // Open a row div for each group of items
    echo '<div class="row">';
    
    // Loop through each recipe in the group
    foreach ($group as $recipe) {
        // Display the recipe item
        echo '<div class="col-lg-3">'; // Adjust column width as needed
        echo '<div class="flex flex-column justify-content-start bg-bg p-4 rounded" style="width: fit-content; min-width: 250px">';
        $imageUrl = 'public/images/recipesImages/' . $recipe->image_url;
        $defaultImageUrl = 'https://www.allrecipes.com/thmb/5SdUVhHTMs-rta5sOblJESXThEE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11691-tomato-and-garlic-pasta-ddmfs-3x4-1-bf607984a23541f4ad936b33b22c9074.jpg'; // Spécifiez le chemin de votre image par défaut
        
        // Vérifie si l'image existe dans le dossier
        if (file_exists($imageUrl)) {
            echo '<img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src="' . $imageUrl . '" />';
        } else {
            // Si l'image n'existe pas, affichez l'image par défaut
            echo '<img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src="' . $defaultImageUrl . '" />';
        }
        echo '<div class="mt-4">';
        echo '<p style="margin: 0;">' . $recipe->calories . ' Cal</p>';
        echo '<p class="fw-bold" style="font-size: 20px; padding-top: 0px">' . $recipe->name . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    // Close the row div for the group
    echo '</div>';
}

// Close the container div for the list
echo '</div>';

