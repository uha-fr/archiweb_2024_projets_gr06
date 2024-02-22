<?php foreach ($data as $row) : ?>
    <div class="d-flex container-fluid bg-dark-gray align-items-center text-white hoverscale client-user" style="width: 100%; justify-content: space-around; border-radius: 10px; cursor: pointer;" id="user-<?= $row->id ?>" data-user-id="<?= $row->id ?>" data-user-name="<?= $row->fullname ?>">
        <p style="width: 30%; margin: 10px 0">
            <?= htmlspecialchars($row->fullname) ?>
        </p>
        <p style="width: 26%; margin: 15px 0" id="accept-request-<?php echo $row->id ?>">
            Accept
        </p>
        <p style="width: 10%; margin: 15px 0" id="decline-request-<?php echo $row->id ?>">
            Decline
        </p>

    </div>
    <style>
        .temp-bg-color {
            background-color: #28E0B2;
        }
    </style>

<?php endforeach; ?>
<script>
    $(document).ready(function() {
        $('[id^="accept-request-"]').on('click', function() {
            // Code à exécuter lorsque "Accept" est cliqué
            var userId = this.id.replace('accept-request-', '');
            console.log('Accept clicked for user ID:', userId);
            performAjaxRequest(
                "POST",
                "updateNotification",
                "&notifState=Accept&senderId=" + userId,
                "",
                ""
            );

        });

        $('[id^="decline-request-"]').on('click', function() {
            // Code à exécuter lorsque "Decline" est cliqué
            var userId = this.id.replace('decline-request-', '');
            console.log('Decline clicked for user ID:', userId);
            performAjaxRequest(
                "POST",
                "updateNotification",
                "&notifState=Decline&senderId=" + userId,
                "",
                ""
            );

        });
    });
</script>