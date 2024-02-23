<?php foreach ($data as $row) :
    $statusText = '';
    $bgColor = '';
    if ($row->notification_type == 3) {
        $statusText = 'Declined';
        $bgColor = 'background-color:#F88F99'; // pourpre
    } elseif ($row->notification_type == 1) {
        $statusText = 'Waiting';
    } elseif ($row->notification_type == 2) {
        $statusText = 'Accepted';
        $bgColor = 'background-color:#75d44c'; // verte
    } else {
        $statusText = 'Unknown'; // cas où la valeur de $row->notification_type n'est pas prévue
        $bgColor = 'background-color:#4169E1'; // blue
    }
?>
    <div class="d-flex container-fluid bg-dark-gray align-items-center text-white hoverscale client-user" style="width: 100%; justify-content: space-between; border-radius: 10px; cursor: pointer;<?= $bgColor ?>" id="notif-user-<?= $row->id ?>" data-user-id="<?= $row->id ?>" data-user-name="<?= $row->fullname ?>">
        <p style="width: 20%; margin: 10px 0">
            <?= htmlspecialchars($row->fullname) ?>
        </p>
        <?php if ($row->notification_type == 1) : // Si la notif est en attente on peut l'accepter ou décliner
        ?>
            <p style="width: 20%; margin: 15px 0" id="accept-request-<?php echo $row->id ?>">
                Accept
            </p>
            <p style="width: 10%; margin: 15px 0" id="decline-request-<?php echo $row->id ?>">
                Decline
            </p>
        <?php endif; ?>
        <p style="width: 20%; margin: 15px 0" id="status-request-<?php echo $row->id ?>">
            <?= $statusText ?>
        </p>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        function getUserFromNotif() {
            performAjaxRequest(
                "GET",
                "getUsersFromNotifications",
                "",
                "",
                ""
            );
        }
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