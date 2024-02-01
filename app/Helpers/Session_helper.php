<?php

namespace Manger\Helpers;

class Session_helper
{
    public static function startSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

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

    public function redirect($location)
    {
        header("location : " . $location);
        exit();
    }
}
