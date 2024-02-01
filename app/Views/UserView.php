<?php

namespace Manger\Views;

class UserView
{

    function view_page($page)
    {
        start_stream();

        $filePath = TEMPLATESDIR . DS . 'user' . DS . $page . '.php';

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            include TEMPLATESDIR . DS . 'user' . DS . 'login.php';
        }
        return end_stream();
    }
}
