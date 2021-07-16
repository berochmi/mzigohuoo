<?php

class UsersController extends Controller
{

    private $Users,$UserGroups;


    private $arr_display_vals = ["fname","lname","mname","staff_id", "username", "password","role","deleted","reset_password"];

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
   
        $this->Users = new Users();
        $this->UserGroups = new UserGroups();
      
    }

    public function addAction()
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["back_to_1"] = "";
        $vars["action"] = "";
        foreach ($this->arr_display_vals as $value) {
            $vars[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
        }
        $vars['rs_user_roles'] = $this->UserGroups->vAll(["order"=>"order by user_group_name asc"]);
        
        $this->view->setLayout('layout_main');
        $this->view->render('users/add', $vars);
    }

    public function addUserAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed</p>";
        $arr_inps_req = [
            "fname" => "First Name","lname" => "Last Name", "role" => "User Role", "username" => "Username"
        ];
        $check = checkLenArrVals($arr_inps_req, $_POST);
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"])) {
            //Check if Product Name is Unique
            $_POST["password"] = $_POST["username"];
            $_POST["access_code"] = "1234";
            if ($this->Users->isThere($_POST) == 0) {
                $_POST['created_by'] = $_POST['edited_by'] = $_SESSION['user_id'];
                $_POST["user_group_id"] = $_POST["role"];
                if ($this->Users->add($_POST)) {
                    $fb_msg_o["user_id"] = $this->Users->getLastId();
                    $fb_msg_o["matokeo"] = 'success';
                    $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>User Succesfully Added</p>";
                }
            } else {
                $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>User Already In the Database!s</p>";
            }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
        }

        echo json_encode($fb_msg_o);
    }

    public function loadUser3AjaxAction(){
        $vars['rs_items'] =  $this->Users->vOneById($_POST);
        $this->view->partialWithVars('users', 'rs_user', $vars);
    }

    public function allAction($param_1 = '')
    {
       
        $Pagination = new Pagination();
        $arr_display_vals = ["search_term"];
        $vars = [];
        $vars['fb_msg'] = "";
        $vars['action'] = "";
        $vars['back_to_1'] =  "";
        $vars['search_term'] = "";
        $vars['rs_users']  = null;
        foreach ($arr_display_vals as $key) {
            if ($key == "date_to") {
                $vars[$key] = isset($_SESSION[$key]) ? $_SESSION[$key] : date("Y-m-d");
            } else {
                $vars[$key] = isset($_SESSION[$key]) ? $_SESSION[$key] : "";
            }
        }
        if (isset($_POST["btn_search"]) || isset($_POST["btn_export"])) {
            foreach ($arr_display_vals as $key) {
                $vars[$key] = (isset($_SESSION[$key]) && ($_SESSION[$key] == $_POST[$key])) ? $_SESSION[$key] : $_POST[$key];
                $_SESSION[$key] = $_POST[$key];
            }
        }
        //Get $_GET value
        $param_1 = (int)$param_1;
        $pg_no = $param_1 == 0 ? 1 : $param_1;
        $rows_per_pg = 50;
        
        $da1 = [
            "order" => "order by fname,lname,mname asc ", 'pg_no' => $pg_no, 
            'rows_per_pg' => $rows_per_pg, 
            'search_term' => $vars['search_term'] 
        ];

        
        $vars['rs_users'] = $this->Users->allPaged($da1);
        //dnd($vars['rs_products']);
        $tot_rows = $this->Users->allPagedCount($da1);
 
        
        $lst_pg = ceil($tot_rows / $rows_per_pg);
        if ($pg_no > $lst_pg && $tot_rows != 0) {
            $pg_no = $lst_pg;
            $vars["fb_msg"] = $tot_rows == 1 ? "<p class='alert alert-success font-weight-bold rounded-0'>$tot_rows Record Found.</p>" : "<p class='alert alert-success'>$tot_rows Records Found.</p>";
        } else if ($tot_rows == 0) {
            $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold rounded-0'>No Records Found.</p>";
        }


        if (isset($_POST['btn_export'])) {
            $keys_vals = ['product_name' => "Product Name", "product_uom" => "UOM", "product_stock_level" => "Stock Balance",
            "product_rol"=>"ReOrder Level"];
            $doc_name = "products";
            $da1['rows_per_pg'] = $tot_rows;
            $all = $this->Products->allPaged($da1);
            Tool::csvMarker03($all, $keys_vals, $doc_name);
        }



        $vars['pg_no'] = $pg_no;
        $vars['rows_per_pg'] = $rows_per_pg;
        $Pagination->setRowsPerPg($rows_per_pg);
        $vars['pagination'] = $Pagination->paginate($tot_rows, PROOT . 'users/all/', $pg_no);
        $this->view->setLayout('layout_main');
        $this->view->render('users/all', $vars);
    }

    public function changePasswordAction()
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["back_to_1"] = "";
        $vars["action"] = "";
        foreach ($this->arr_display_vals as $value) {
            $vars[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
        }
        $vars['rs_user_roles'] = $this->UserGroups->vAll(["order"=>"order by user_group_name asc"]);
        
        $this->view->setLayout('layout_main');
        $this->view->render('users/change_password', $vars);
    }

    public function changePasswordAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed</p>";
        $arr_inps_req = ["password" => "Password"];
        $check = checkLenArrVals($arr_inps_req, $_POST);
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"])) {
                $_POST["user_id"]=$_POST['created_by'] = $_POST['edited_by'] = $_SESSION['user_id'];
                if ($this->Users->updatePassword($_POST)) {
                    $fb_msg_o["matokeo"] = 'success';
                    $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Password Succesfully Updated!</p>";
                }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
        }

        echo json_encode($fb_msg_o);
    }

    public function eOneAction($param_1)
    {
        $vars['fb_msg'] = '';
        $vars['action'] = "";
        $vars['back_to_1'] =  PROOT . 'users/all';
        $view_path = "users/e_one";
       
        if(!empty($param_1) && filter_var($param_1,FILTER_VALIDATE_INT)){
            $rs_param_1 = $this->Users->vOneById(["user_id"=>$param_1]);
            
            if(count($rs_param_1)){
               
                foreach ($this->arr_display_vals as $vals) {
                    if (key_exists($vals, $rs_param_1[0])) {
                        $vars[$vals] = $rs_param_1[0][$vals];
                    } else {
                        $vars[$vals] = '';
                    }
                }
                $vars['user_id'] = adz_encrypt($param_1);
                $vars['rs_user_roles'] = $this->UserGroups->vAll(["order"=>"order by user_group_name asc"]);

                
            } else {
                $view_path = "generals/fb_page";
                $vars['fb_msg'] = "<h4 class='alert alert-danger text-center'>User Does Not Exists.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Menu Items</a></h4>";

            }
           
        } else {
            $view_path = "generals/fb_page";
            $vars['fb_msg'] = "<h5 class='alert alert-danger text-center'>User Does Not Exists.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></h5>";

        }
       

        $this->view->setLayout("layout_main");
        $this->view->render($view_path,$vars);
    }

    public function editUserAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed!</p>";
        $arr_inps_req = [
            "fname" => "First Name","lname" => "Last Name", "role" => "User Role", "username" => "Username","deleted"=>"Status"
        ];
        
        $check = checkLenArrVals($arr_inps_req, $_POST);
       
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"])) {
           
            $_POST['user_id'] = adz_decrypt($_POST["user_id"]);
           
            if ($this->Users->isThereDup($_POST) == 0) {
               
                $_POST['created_by'] = $_POST['edited_by'] = $_SESSION['user_id'];

                if ($this->Users->updateUser($_POST)) {
                    
                    $fb_msg_o["matokeo"] = 'success';
                    $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>User Succesfully Added</p>";
                }
            } else {
                $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>User Already In the Database!s</p>";
            }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
        }
        

        echo json_encode($fb_msg_o);
    }

    public function resetPasswordAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed</p>";
        $arr_inps_req = ["reset_password" => "Password"];
        $check = checkLenArrVals($arr_inps_req, $_POST);
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"])) {
                $_POST["user_id"]=$_POST['created_by'] = $_POST['edited_by'] = $_SESSION['user_id'];
                $_POST["password"] = $_POST["reset_password"];
                if ($this->Users->updatePassword($_POST)) {
                    $fb_msg_o["matokeo"] = 'success';
                    $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Password Succesfully Updated!</p>";
                }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
        }

        echo json_encode($fb_msg_o);
    }

}