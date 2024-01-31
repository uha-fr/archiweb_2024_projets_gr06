<?php

namespace Manger\View;

require_once VIEWSDIR.DS.'utils'.DS.'global.php';

class UserView {

    function view_page($page){
        start_stream();

        include TEMPLATESDIR.DS.'user'.DS.$page.'.php';

        return end_stream();
    }
    
}
