<?php
function start_stream(){
		ob_start();
};

function end_stream(){
	$content = ob_get_clean();
    return $content;
}