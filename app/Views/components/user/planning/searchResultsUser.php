<?php foreach ($data as $row) : ?>
    <div class="d-flex container-fluid bg-dark-gray align-items-center text-white hoverscale client-user" style="width: 100%; justify-content: space-around; border-radius: 10px; cursor: pointer;" id="user-<?= $row->id ?>" data-user-id="<?= $row->id ?>" data-user-name="<?= $row->fullname ?>">
        <p style="width: 30%; margin: 10px 0">
            <?= htmlspecialchars($row->fullname) ?>
        </p>
        <p style="width: 26%; margin: 15px 0">
            <?= htmlspecialchars($row->email) ?>
        </p>
        <p style="width: 10%; margin: 15px 0">
            <?= htmlspecialchars($row->age) ?> ans
        </p>

    </div>
    <style>
        .temp-bg-color {
            background-color: #28E0B2;
        }
    </style>

<?php endforeach; ?>