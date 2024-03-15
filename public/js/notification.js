$(document).ready(function () {

    // on doit attacher l'évènement au parent, car les enfants ne sont pas encore créés
    $('#client-list-results').on('click', '.client-user', function () {
        const userId = $(this).data('user-id');
        console.log(userId);
        performAjaxRequest(
            "POST",
            "sendNotification",
            "&receiverId=" + userId,
            "",
            ""
        );
    });


    // pour récupérer le nombre de notif, et les mettre en session
    function getNotif() {
        performAjaxRequest(
            "GET",
            "countNotification",
            "",
            "",
            ""
        );
    }

    // pour récupérer les users ayant envoyé des notifications 
    function getUserFromNotif() {
        performAjaxRequest(
            "GET",
            "getUsersFromNotifications",
            "",
            "",
            ""
        );
    }

    getNotif();
    getUserFromNotif();

    // pour effectuer une recherche
    function performSearch() {
        var inputValue = $('#client-list-search').val();
        performAjaxRequest(
            "GET",
            "clientSearch",
            "&searchValue=" + inputValue,
            function (data) {
                console.log(data);
                $("#client-list-results").html(data);
            },
            ""
        );
    }

    var debouncedSearch = debounce(performSearch, 700);

    $('#client-list-search').on('input', function () {
        debouncedSearch();
    });
});