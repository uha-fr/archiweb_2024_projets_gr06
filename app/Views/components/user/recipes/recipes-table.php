<!-- component to show recipes list -->
<table class="table table-striped table-sm table-bordered">
    <caption>Table of recipes</caption>
<thead>
            <tr class="text-center">
            <th>Recipe ID</th>
            <th>Recipe Name</th>
            <th>calories number</th>
            <th>image-url</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr class="text-center text-secondary">
            <tr>
                <td><?= $recipe->id ?></td>
                <td><?= $recipe->name?></td>
                <td><?= $recipe->calories?></td>
                <td><?= $recipe->image_url?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
