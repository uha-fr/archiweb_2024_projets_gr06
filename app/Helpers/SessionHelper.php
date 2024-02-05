<?php

namespace Manger\Helpers;

/**
 * Session Helper
 *
 * Provides helper methods for working with sessions, flash messages, and redirects.
 */
class SessionHelper
{
    /**
     * Start Session
     *
     * Starts the session if not already started.
     *
     * @return void
     */
    public static function startSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * Flash Message.
     *
     * Manages the creation and display of flash messages.
     * It stores temporary messages in the session, displays them when needed, and then removes them.
     * 
     * @param string $name    The name of the flash message.
     * @param string $message The message content.
     * @param string $class   The CSS class for styling the message.
     * @return void
     */
    public static function flash($name = '', $message = '', $class = 'form-message form-message-red')
    {
        self::startSession();

        if (!empty($name)) {
            if (!empty($message) && empty($_SESSION[$name])) {
                if (!empty($_SESSION[$name])) {
                    unset($_SESSION[$name]);
                }
                if (!empty($_SESSION[$name . '_class'])) {
                    unset($_SESSION[$name . '_class']);
                }
                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            } elseif (empty($message) && !empty($_SESSION[$name])) {
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo "<div class='" . $class . "'>" . $_SESSION[$name] . "</div>";
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }

    /**
     * Redirect
     *
     * Performs a redirect to the specified location.
     *
     * @param string $location The URL to redirect to.
     * @return void
     */
    public function redirect($location)
    {
        header("Location: " . $location);
        exit();
    }
}
