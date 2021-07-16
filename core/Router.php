<?php
Class Router{

    
    public static function route($url){
        //Session::checkUsername();
        //Session::njeNdani();
        //Session::checkUsername();
        //Getting Controller from Url
        $controller = isset($url[0]) && $url[0] != '' ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
        $controller_name = str_replace('Controller','',$controller);
       
        array_shift($url);//Removing index 0 from $url
        


        //Getting Action/Method:
        $action = isset($url[0]) && $url[0] != '' ? $url[0]."Action" : "indexAction";
        $action_name  = str_replace('Action','',$action);
        array_shift($url);
        if($controller_name != "Login"){
            Session::checkUsername();
            Session::njeNdani();
        }
        $arr_allowed = [];
        //Params
        $query_params = $url;
        if(class_exists($controller)){
            $dispatch = new $controller($controller_name,$action);
        }else {
            //self::redirect("home/login");
            //die("The Class - ".$controller_name." does not exists");
            $vars['fb_msg'] = "<p class='text-danger font-weight-bold'>This Class $controller_name Doesn't Exists! </p>";
            $view = new View();
            $view->setLayout( 'layout_main' );
            $view->view->render( 'generals/fb_page', $vars );
        }
        

        if(method_exists($controller,$action)){
            //update controllers_actions db
            ControllersActions::add(['controller_name'=>$controller_name,'action_name'=>$action_name]);
          
            if($controller_name != "Login"){
                    
                $allowed = false;
                $User = new Users();
                $rs_user = $User->selectUsername2(['username'=>$_SESSION['username']]);
               
                if(count($rs_user) == 1 && $rs_user != null){
                    $role = $rs_user[0]['user_group_name'];
                    $rs_user_grp = UserGroups::vPermsByName(['user_group_name'=>$role,'order'=>'']);
                    if(count($rs_user_grp)>0 && $rs_user_grp !=null){
                        foreach($rs_user_grp as $item){
                            if((strtolower($item['controller_allowed']) == strtolower($controller_name) || $item['controller_allowed'] == '*' ) && 
                            (strtolower($item['action_allowed']) == strtolower($action_name) ||$item['action_allowed'] == '*' )){
                                $allowed = true;
                            break;
                            }
                        }
                        if($allowed){
                            call_user_func_array([$dispatch,$action],$query_params);
                        } else{
                            $vars['fb_msg'] = "<p class=' alert alert-danger font-weight-bold text-center'>You Do Not Have the Right Permissions to view this Page! </p>";
                            $view = new View();
                            $view->setLayout( 'layout_main' );
                            $view->render( 'generals/fb_page', $vars );
                            
                        }

                    } else {
                        //Logout user
                        self::redirect('logout');
                    }
    
                } else {
                    ////Logout user
                    self::redirect('logout');
                }

            } else {
                call_user_func_array([$dispatch,$action],$query_params);
            }
         
            
            
        } else {
            //die("The Method does not exists $action in the Controller - ".$controller_name);
            $vars['fb_msg'] = "<p class=' alert alert-danger font-weight-bold text-center'>This Method $action_name Doesn't Exists! </p>";
            $view = new View();
            $view->setLayout( 'layout_main' );
            $view->render( 'generals/fb_page', $vars );
        }
    }

    public static function redirect($location){
        if(!headers_sent()){
            header("Location: ".PROOT.$location);
            exit();
        } else {
            $script = '<script type="text/javascript">';
            $script .= 'window.location.href="'.PROOT.$location.'";';
            $script .= '</script>';
            $script .= '<noscript>';
            $script .= '<meta http-equiv="refresh" content="0;url'.$location.'"/>';
            $script .= '</noscript>';
            echo $script;
        }
    }

}