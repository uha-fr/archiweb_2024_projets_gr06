<?php foreach ($data as $row): ?>
    <div class="d-flex container-fluid bg-dark-gray align-items-center text-white hoverscale recipe-item"
        style="width: 100%; justify-content: space-between; border-radius: 10px; cursor: pointer;"
        id="recipe-<?= $row->id ?>" data-recipe-id="<?= $row->id ?>" data-recipe-name="<?= $row->name ?>">
        <p style="width: 63%; margin: 15px 0">
            <?= htmlspecialchars($row->name) ?>
        </p>
        <p style="width: 18%; margin: 15px 0">
            <?= htmlspecialchars($row->creator != 42 ? "By you" : "Global") ?>
        </p>
        <p style="width: 18%; margin: 15px 0">
            <?= htmlspecialchars($row->calories) ?> Cal
        </p>
    </div>

<?php endforeach; ?>