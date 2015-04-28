<?php

namespace LittleNinja\Lib;

class Session
{
    public static function init()
    {
        if (session_id() == '') {
            session_start();
        }
    }

    /**
     * Sets a specific value to a specific key of the session
     *
     * @param mixed $key key
     * @param mixed $value value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Returns the value of a specific key of the session
     *
     * @param mixed $key Usually a string, right ?
     * @return mixed the key's value or nothing
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * Adds a value as a new array element to the key.
     * useful for collecting error messages etc
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function add($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Deletes the session (= logs the user out)
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Checks if the user is logged in or not
     *
     * @return bool user's login status
     */
    public static function userIsLoggedIn()
    {
        return (Session::get('user_logged_in') ? true : false);
    }
}
