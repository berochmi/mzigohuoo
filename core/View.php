<?php

class View{

    protected $_head,$_body,$_siteTitle = SITE_TITLE,$_outputBuffer,$_layout = DEFAULT_LAYOUT;
    protected $_section_js;

    public function __construct()
    {
        
    }

    public function render($view_name,$vars = []){
        $view_arr = explode("/",$view_name);
        $view_string = implode(DS,$view_arr);
        extract($vars);
        if(file_exists(ROOT.DS.'app'.DS.'views'.DS.$view_string.'.php')){
            include(ROOT.DS.'app'.DS.'views'.DS.$view_string.'.php');
            include(ROOT.DS.'app'.DS.'views'.DS.'layouts'.DS.$this->_layout.'.php');
        } else {
            die("The view -".$view_name." doesn't exists");
        }
    }


    public function content($type){
        if($type == 'head'){
            return $this->_head;
        } elseif($type == 'body'){
            return $this->_body;
        } elseif($type == 'section_js'){
            return $this->_section_js;
        }
        return false;
    }

    public function start($type){
        $this->_outputBuffer = $type;
        ob_start();
    }

   


    public function end(){
        if($this->_outputBuffer == 'head'){
            $this->_head = ob_get_clean();
        } elseif($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean();
        }elseif($this->_outputBuffer == 'section_js'){
            $this->_section_js = ob_get_clean();
        } else {
            die("You Must First Run Start!");
        }
        
    }

    public function setSiteTitle($title){
        $this->_siteTitle = $title;

    }

    public function siteTitle(){
        return $this->_siteTitle;

    }

    public function setLayout($path){
        $this->_layout = $path;

    }

    public function insert($path){
        include ROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';
       }
  
      public function partial($group, $partial){
        include ROOT . DS . 'app' . DS . 'views' . DS . $group . DS . 'partials' . DS . $partial . '.php';
      }

      public function partialWithVars($group, $partial,$vars =[]){
            extract($vars);
            include ROOT . DS . 'app' . DS . 'views' . DS . $group . DS . 'partials' . DS . $partial . '.php';
      }


}