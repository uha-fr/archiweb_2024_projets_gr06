<?php

namespace Manger\Views;

class AdminView
{

    function view_page($page)
    {
        start_stream();

        $filePath = TEMPLATESDIR . DS . 'admin' . DS . $page . '.php';

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            include TEMPLATESDIR . DS . 'user' . DS . 'login.php';
        }
        return end_stream();
    }
}
