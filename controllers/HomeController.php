<?php


use Core\Controller;

class HomeController extends Controller
{
    function indexAction(){
        $this->render('index');
    }
}