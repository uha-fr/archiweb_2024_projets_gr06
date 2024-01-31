<!-- template/table-user.php -->


    <table class="table table-striped table-sm table-bordered">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Full name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr class="text-center text-secondary">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <!-- Action buttons -->
                        <!-- Ensure to properly handle and escape output as needed -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
