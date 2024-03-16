<?php
// Assuming $recipes is an array containing the items retrieved from the database
// Divide recipes into groups of 4
$recipeGroups = array_chunk($recipes, 4);
?>
<div class="list-container row row-cols-1 row-cols-md-4 g-4">
    <?php foreach ($recipeGroups as $groupIndex => $group): ?>
        <?php foreach ($group as $recipeIndex => $recipe): ?>
            <?php
            $imageUrl = 'public/images/recipesImages/' . $recipe->image_url;
            $defaultImageUrl = 'https://www.allrecipes.com/thmb/5SdUVhHTMs-rta5sOblJESXThEE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11691-tomato-and-garlic-pasta-ddmfs-3x4-1-bf607984a23541f4ad936b33b22c9074.jpg'; 
            $imageSrc = file_exists($imageUrl) ? $imageUrl : $defaultImageUrl;
            ?>
            <div class="col mb-4">
            <div class="flex flex-column justify-content-start bg-bg p-4 rounded" style="height:350px;max-height:350px; min-width: 250px;max-width: 250px;">
                    <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src="<?php echo $imageSrc; ?>" />
                    <div class="mt-4">
                        <p style="margin: 0;"><?php echo $recipe->calories; ?> Cal</p>
                        <p class="fw-bold" style="font-size: 20px; padding-top: 0px;"><?php echo $recipe->name; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
