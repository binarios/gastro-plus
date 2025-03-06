<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $this->view->render('home/index',['title' => 'Home', 'lang' => 'de']);
    }
}