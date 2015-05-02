<?php namespace LittleNinja\Lib;

class Redirect
{
    public static function home()
    {
        header('Location: ' . LN_URL . '/home/index');
        exit;
    }
    public static function to($path)
    {
        header('Location: ' . LN_URL . $path);
        exit;
    }
}
