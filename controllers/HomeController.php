<?php


use Core\Controller;

class HomeController extends Controller
{
    /**
     * @throws Exception
     */
    function indexAction(){
        $this->render('index');
    }
}