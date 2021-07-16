<?php

define("DS",DIRECTORY_SEPARATOR);
define("ROOT",dirname(__FILE__));


require_once(ROOT.DS.'config'.DS.'config.php');
require_once(ROOT.DS.'app'.DS.'lib'.DS.'helpers'.DS.'functions.php');

//Auto load Classes
function my_autoload($class_name){
    if(file_exists(ROOT.DS.'core'.DS.$class_name.'.php')){
        require_once(ROOT.DS.'core'.DS.$class_name.'.php');
    } elseif(file_exists(ROOT.DS.'app'.DS.'controllers'.DS.$class_name.'.php')){
        require_once(ROOT.DS.'app'.DS.'controllers'.DS.$class_name.'.php');
    } elseif(file_exists(ROOT.DS.'app'.DS.'models'.DS.$class_name.'.php')){
        require_once(ROOT.DS.'app'.DS.'models'.DS.$class_name.'.php');
    }
}
spl_autoload_register('my_autoload');
session_start();
//Session::checkUsername();

$url = isset($_SERVER["PATH_INFO"]) ? explode('/',ltrim($_SERVER["PATH_INFO"],"/")) : [];
//Route the url
Router::route($url);