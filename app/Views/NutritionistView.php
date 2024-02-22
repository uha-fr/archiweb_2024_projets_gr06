<?php

namespace Manger\Views;

/**
 * Access the PHP files to display
 *
 * Find the PHP files to display so the Controller can display them.
 *
 */
class NutritionistView
{

    /**
     * Send the requested Nutritionniste page to the Controller.
     *
     * Initiates output buffering, includes the specified page template, and returns the captured content.
     * If the specified template file does not exist, the *404-error.php* template is included by default.
     *
     * @param mixed $page The page to be displayed.
     * @return string The captured content from the output buffer.
     */
    public function viewPage($page)
    {
        startStream();

        $filePath = TEMPLATESDIR . DS . 'nutritionist' . DS . $page . '.php';

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            include TEMPLATESDIR . DS . '404-error.php' ; 
        }

        return endStream();
    }

    
}
