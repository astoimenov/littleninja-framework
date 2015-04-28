<?php namespace LittleNinja\Controllers;

use LittleNinja\Lib\View;
use LittleNinja\Models\Post;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct(get_class(), 'BaseModel');
    }

    public function index()
    {
        View::render('home/index');
    }
}
