<?php foreach ($data as $row): ?>
    <div class="d-flex container-fluid bg-gray" style="width: 100%; justify-content: space-between; border-radius: 10px">
        <p style="width: 63%">
            <?= htmlspecialchars($row->name) ?>
        </p>
        <p style="width: 13%">By
            <?= htmlspecialchars($row->creator) ?>
        </p>
        <p style="width: 23%">
            <?= htmlspecialchars($row->calories) ?> Cal
        </p>
    </div>

<?php endforeach; ?>