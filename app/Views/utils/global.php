<?php

/**
 * Initiates output buffering using the ob_start() function.
 *
 * @return void
 */
function start_stream()
{
	ob_start();
};

/**
 * Ends output buffering.
 * 
 * Retrieves the buffered content using ob_get_clean(), and returns the captured content.
 *
 * @return string The captured content from the output buffer.
 */
function end_stream()
{
	$content = ob_get_clean();
	return $content;
}
