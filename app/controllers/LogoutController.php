<?php

class LogoutController extends Controller{

    public function __construct($controller,$action)
    {
        parent::__construct($controller,$action);
    }

    public function indexAction(){
        //$this->view->setLayout('layout_main');
        $vars = null;
        Session::logOut();
        Router::redirect("login");
    
    }

    

    //Session::logOut();
}