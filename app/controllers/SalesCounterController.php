<?php
include(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'qr' . DS . 'qrcode.class.php');
//include(ROOT.DS.'app'.DS.'lib'.DS.'helpers'.DS.'qr2'.DS.'qrlib.php');
class SalesCounterController extends Controller
{
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction()
    {
        $vars["packages_sent"] = 0;
        $vars["packages_received"] = 0;
        $vars["packages_collected"] = 0;
        $vars["percent_collected"] = 0;
        $view_path = "salesCounter/index";

        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function sendPackageAction()
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["action"] = "";

        //$qrcode->displayFPDF ($fpdf, $x, $y, $s, $background, $color);


        $Branches = new Branches();
        $vars['rs_bases'] = $Branches->allBases(["order" => " order by base_name asc"]);
        $vars["city_from"] = $_SESSION["my_base"];
        $vars["rs_branch_details"] = $Branches->vOneByBranchId(["branch_id" => $_SESSION["my_branch_id"]]);
        $vars["from_branch_id"] = $_SESSION["my_branch_id"];

        $arr_display_vals = [
            "city_from", "city_to", "to_branch_id", "sender_name", "sender_contacts", "package_description", "package_qty",
            "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time"
        ];
        foreach ($arr_display_vals as $vals) {
            $vars[$vals] = isset($_POST[$vals]) ? $_POST[$vals] : "";
        }

        $vars["rs_branches_to"] = $Branches->vAllByBase(['my_base' => $vars["city_to"]]);
        //dnd($vars["to_branch_id"]);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $arr_inps_req = [
                "city_to" => "City To", "to_branch_id" => "Branch Name", "sender_name" => "Sender Name",
                "sender_contacts" => "Sender Contacts", "package_description" => "Package Description", "package_qty" => "Package QTY",
                "package_amount_paid" => "Amount Paid", "date_received" => "Date Received", "time_received" => "Time Received",
                "receiver_name" => "Receiver Name", "receiver_contacts" => "Receiver Contacts", "collection_date" => "Collection Date",
                "collection_time" => "Collection Time"
            ];
            $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array_map('trim', $data);
            $check = checkLenArrVals($arr_inps_req, $data);
            $err_num = 0;
            $num_keys = ["package_amount_paid", "package_qty"];
            foreach ($num_keys as $k) {
                $data[$k] = str_replace(",", "", $data[$k]);
                if (trim($data[$k]) == "" || $data[$k] == 0) {
                    $data[$k] = 0;
                } elseif (!filter_var($data[$k], FILTER_VALIDATE_FLOAT)) {
                    $err_num++;
                    $data["err_num" . $k] = $data[$k];
                }
            }
            if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {
                $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];
                $data["city_from"] = $_SESSION["my_base"];
                $data["from_branch_id"] = $_SESSION["my_branch_id"];
                $OrderSettings = new OrderSettings();
                $data["receipt_no"] = $OrderSettings->getNextNo(["order_type" => "RECEIPT NUMBERS"]);
                $data["sending_package_status"] = "DROP OFF";
                $SendingPackages = new SendingPackages();
                if ($SendingPackages->addSendingPackage($data)) {
                    $sending_package_id = $SendingPackages->getLastId();
                    $OrderSettings->incrementNextNo(["order_type" => "RECEIPT NUMBERS", "edited_by" => $_SESSION["user_id"]]);
                    $QRcode = new QRcode($data["receipt_no"], 'H'); // error level: L, M, Q, H
                    $QRcode->displayPNG(200, [255, 255, 255], [0, 0, 0], ROOT . DS . "images" . DS . "qrcodes" . DS . $data["receipt_no"] . ".png", 0);
                    Router::redirect("SalesCounter/vOneSentPackage/$sending_package_id");
                    $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Data Successfully Added!</p>";
                } else {
                    $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Something Went Wrong Please Check With Admin!</p>";
                }
            } else {
                $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
                $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
            }
        }





        $view_path = "salesCounter/sendPackage";
        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function loadBranchesToAjaxAction()
    {
        $Branches = new Branches();
        $vars["rs_branches_to"] = $Branches->vAllByBase(['my_base' => $_POST["city_to"]]);
        $vars["to_branch_id"] = isset($_POST["to_branch_id"]) ? $_POST["to_branch_id"] : 0;
        $this->view->partialWithVars('salesCounter', 'rs_branches_to', $vars);
    }

    public function allSentPackagesAction($param_1 = 1)
    {
        $SendingPackages = new SendingPackages();
        $Pagination = new Pagination();
        $arr_display_vals = ["search_sender_name", "search_receiver_name", "search_receipt_no", "date_from", "date_to"];
        $view_path = 'salesCounter/allSentPackages';
        $vars['fb_msg'] = "";
        $vars['action'] = "";
        $vars['back_to_1'] = "";
        $vars['heading_1'] = "Select Site";
        $vars['rs_all_sent_packages'] = null;

        foreach ($arr_display_vals as $key) {
            if ($key == "date_to") {
                $vars[$key] = isset($_SESSION[$key]) ? $_SESSION[$key] : date("Y-m-d");
            } else if ($key == "date_from") {
                $vars[$key] = isset($_SESSION[$key]) ? $_SESSION[$key] : date("Y-m-01");
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
        $param_1 = (int) $param_1;
        $pg_no = $param_1 == 0 ? 1 : $param_1;
        $rows_per_pg = 50;

        $da1 = [
            "order" => "order by date_received desc", 'pg_no' => $pg_no, 'rows_per_pg' => $rows_per_pg,
            "search_sender_name" => $vars["search_sender_name"],
            "search_receiver_name" => $vars["search_receiver_name"],
            "search_receipt_no" => $vars["search_receipt_no"],
            "date_from" => $vars["date_from"],
            "date_to" => $vars["date_to"],
        ];
        $tot_rows = $SendingPackages->allPagedCount($da1);
        $vars['rs_all_sent_packages'] = $SendingPackages->allPaged($da1);

        $lst_pg = ceil($tot_rows / $rows_per_pg);
        if ($pg_no > $lst_pg && $tot_rows != 0) {
            $pg_no = $lst_pg;
            $vars["fb_msg"] = $tot_rows == 1 ? "<p class='alert alert-success font-weight-bold rounded-0'>$tot_rows Record Found.</p>" : "<p class='alert alert-success'>$tot_rows Records Found.</p>";
        } elseif ($tot_rows == 0) {
            $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold rounded-0'>No Records Found.</p>";
        }

        if (isset($_POST['btn_export'])) {
            $keys_vals = [
                'site_id' => "Site Id", "site_name" => "Branch Name", "site_base" => "Base", "client_name" => "Client Name",
                "site_poc_name" => "Branch POC.", "site_poc_contacts" => "POC Contacts", "site_physical_address" => "Branch Location"
            ];
            $doc_name = "sp_sites";
            $da1['rows_per_pg'] = $tot_rows;
            $all = $SendingPackages->allPaged($da1);
            Tool::csvMarker03($all, $keys_vals, $doc_name);
        }
        $vars['pg_no'] = $pg_no;
        $vars['rows_per_pg'] = $rows_per_pg;
        $Pagination->setRowsPerPg($rows_per_pg);
        $vars['pagination'] = $Pagination->paginate($tot_rows, PROOT . 'SalesCounter/allSentPackages/', $pg_no);
        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function vOneSentPackageAction($param_1)
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["action"] = "";
        $SendingPackages = new SendingPackages();
        $view_path = "salesCounter/vOneSentPackage";
        $vars["back_to_1"] = PROOT . "SalesCounter/allSentPackages";
        $arr_display_vals = [
            "receipt_no",
            "city_from", "city_to", "to_branch_id", "sender_name", "sender_contacts", "package_description", "package_qty",
            "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time"
        ];
        if (!empty($param_1) && filter_var($param_1, FILTER_VALIDATE_FLOAT)) {
            $rs_param_1 = $SendingPackages->vOneByPackageId(["sending_package_id" => $param_1]);
            if (count($rs_param_1)) {
                $Branches = new Branches();
                $vars['rs_bases'] = $Branches->allBases(["order" => " order by base_name asc"]);
                foreach ($arr_display_vals as $vals) {
                    $vars[$vals] = "";
                    if (key_exists($vals, $rs_param_1[0])) {
                        $vars[$vals] = $rs_param_1[0][$vals];
                    }
                    $vars[$vals] = isset($_POST[$vals]) ? $_POST[$vals] : $vars[$vals];
                }
                $vars["rs_branches_to"] = $Branches->vAllByBase(['my_base' => $vars["city_to"]]);
                $vars["sending_package_id"] = $param_1;
                $city_from = $rs_param_1[0]["city_from"];
                $collection_date = $rs_param_1[0]["collection_date"];
                $collection_time = $rs_param_1[0]["collection_time"];
                $sms_sent = $rs_param_1[0]["sms_sent"];
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $arr_inps_req = [
                        "city_to" => "City To", "to_branch_id" => "Branch Name", "sender_name" => "Sender Name",
                        "sender_contacts" => "Sender Contacts", "package_description" => "Package Description", "package_qty" => "Package QTY",
                        "package_amount_paid" => "Amount Paid", "date_received" => "Date Received", "time_received" => "Time Received",
                        "receiver_name" => "Receiver Name", "receiver_contacts" => "Receiver Contacts", "collection_date" => "Collection Date",
                        "collection_time" => "Collection Time"
                    ];
                    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $data = array_map('trim', $data);
                    $check = checkLenArrVals($arr_inps_req, $data);
                    $err_num = 0;
                    $num_keys = ["package_amount_paid", "package_qty"];
                    foreach ($num_keys as $k) {
                        $data[$k] = str_replace(",", "", $data[$k]);
                        if (trim($data[$k]) == "" || $data[$k] == 0) {
                            $data[$k] = 0;
                        } elseif (!filter_var($data[$k], FILTER_VALIDATE_FLOAT)) {
                            $err_num++;
                            $data["err_num" . $k] = $data[$k];
                        }
                    }
                    if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {

                        if (isset($_POST["edit"])) {
                        }
                        if (isset($_POST["send_sms"])) {
                            $sender_name = $data["sender_name"];
                            $receiver_name = $data["receiver_name"];
                            $sender_contacts = "255" . ltrim(str_replace(" ", "", $data["sender_contacts"]), "0");
                            $receiver_contacts = "255" . ltrim(str_replace(" ", "", $data["receiver_contacts"]), "0");
                            //$city_from = $data["city_from"];
                            $city_to = $data["city_to"];
                            $receipt_no = $data["receipt_no"];
                            $collection_date = date("d-M-y", strtotime($collection_time));
                            $data["msg"] = "Mzigo Huoo!\n";
                            $data["msg"] .= "From $sender_name ($city_from) To $receiver_name ($city_to) Has Been DROPPED OFF for dispatch. Expected Arrival Date $collection_date\nReceipt No: $receipt_no";
                            $data["to"] = [
                                ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                                ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                            ];
                            //dnd($data);
                            if ($sms_sent == 0) {
                                if (sendSms($data) == 1) {
                                    $data["sms_sent"] = 1;
                                    $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];
                                    $SendingPackages->updateSendingPackageSMSStatus($data);
                                    $vars['fb_msg'] = "<p class='alert alert-success text-center font-weight-bold'>All SMSs Successfully Sent</p>";
                                } else if (sendSms($data) == 2) {
                                    $vars['fb_msg'] = "<p class='alert alert-warning text-center font-weight-bold'>Not All SMSs have been Sent</p>";
                                } else if (sendSms($data) == 0) {
                                    $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Error In Sending SMSs</p>";
                                }
                            } else {
                                $vars['fb_msg'] = "<p class='alert alert-warning text-center font-weight-bold'>SMS Already Sent</p>";
                            }
                        }
                    } else {
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
                    }
                }
            } else {
                $view_path = "generals/fb_page";
                $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Package Doesn't Exist.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
            }
        } else {
            $view_path = "generals/fb_page";
            $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Please Select a Sent Package.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
        }



        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function receivePackageAction($param_1)
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["action"] = "";
        $SendingPackages = new SendingPackages();
        $view_path = "salesCounter/receivePackage";
        $vars["back_to_1"] = PROOT . "SalesCounter/allSentPackages";
        $arr_display_vals = [
            "receipt_no", "sending_package_status",
            "city_from", "city_to", "to_branch_id", "sender_name", "sender_contacts", "package_description", "package_qty",
            "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time",
            "received_date", "received_time", "received_package_description", "received_package_qty", "received_collection_date", "received_collection_time"
        ];
        if (!empty($param_1) && filter_var($param_1, FILTER_VALIDATE_FLOAT)) {
            $rs_param_1 = $SendingPackages->vOneByPackageId(["sending_package_id" => $param_1]);
            if (count($rs_param_1)) {
                $Branches = new Branches();
                $vars['rs_bases'] = $Branches->allBases(["order" => " order by base_name asc"]);
                foreach ($arr_display_vals as $vals) {
                    $vars[$vals] = "";
                    if (key_exists($vals, $rs_param_1[0])) {
                        $vars[$vals] = $rs_param_1[0][$vals];
                    }
                    $vars[$vals] = isset($_POST[$vals]) ? $_POST[$vals] : $vars[$vals];
                }
                $vars["rs_branches_to"] = $Branches->vAllByBase(['my_base' => $vars["city_to"]]);
                $vars["sending_package_id"] = $param_1;
                $vars["received_package_description"] = $vars["package_description"];
                $vars["received_package_qty"] = $vars["package_qty"];
                $vars["received_collection_date"] = $vars["collection_date"];
                $vars["received_collection_time"] = $vars["collection_time"];
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $arr_inps_req = [
                        "city_to" => "City To", "to_branch_id" => "Branch Name", "sender_name" => "Sender Name",
                        "sender_contacts" => "Sender Contacts", "package_description" => "Package Description", "package_qty" => "Package QTY",
                        "package_amount_paid" => "Amount Paid", "date_received" => "Date Received", "time_received" => "Time Received",
                        "receiver_name" => "Receiver Name", "receiver_contacts" => "Receiver Contacts", "collection_date" => "Collection Date",
                        "collection_time" => "Collection Time",
                        "received_date" => "Date Received", "received_time" => "Received Time", "received_package_description" => "Received Package Description",
                        "received_package_qty" => "Received Qty", "received_collection_date" => "New Collection Date", "received_collection_time" => "New Collection Time"
                    ];
                    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $data = array_map('trim', $data);
                    $check = checkLenArrVals($arr_inps_req, $data);
                    $err_num = 0;
                    $num_keys = ["package_amount_paid", "package_qty", "received_package_qty"];
                    foreach ($num_keys as $k) {
                        $data[$k] = str_replace(",", "", $data[$k]);
                        if (trim($data[$k]) == "" || $data[$k] == 0) {
                            $data[$k] = 0;
                        } elseif (!filter_var($data[$k], FILTER_VALIDATE_FLOAT)) {
                            $err_num++;
                            $data["err_num" . $k] = $data[$k];
                        }
                    }
                    if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {
                        /*
                        if (isset($_POST["receive_package"])) {
                            $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];

                            $data["sending_package_status"] = "ARRIVED";
                            $data["receiving_packages_status"] = "ARRIVED";
                            $SendingPackages = new SendingPackages();
                            if ($SendingPackages->addReceivingPackage($data)) {
                                $SendingPackages->updateSendingPackageStatus($data);
                                $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Package Successfully Received!</p>";
                            } else {
                                $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Something Went Wrong Please Check With Admin!</p>";
                            }
                        }
                        */
                        if (isset($_POST["send_sms"])) {
                            $sender_contacts = "255" . ltrim(str_replace(" ", "", $data["sender_contacts"]), "0");
                            $receiver_contacts = "255" . ltrim(str_replace(" ", "", $data["receiver_contacts"]), "0");
                            $data["msg"] = "Mzigo Huoo!\nARRIVED,Ref No " . $data["receipt_no"] . "\n";
                            $data["msg"] .= "From: " . $data["sender_name"] . ", ";
                            $data["msg"] .= "To: " . $data["receiver_name"] . "\n";
                            $data["msg"] .= "Collection Date: " . date("d-M-y", strtotime($data["collection_date"])) . " " . $data["collection_time"] . " \n";
                            $data["msg"] .= "Location: " . $data["city_to"] . "\n";

                            $data["to"] = [
                                ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                                ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                            ];
                            //dnd($data);
                            //sendSms($data);
                            if (sendSms($data) == 1) {
                                $data["sms_sent"] = 1;
                                $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];
                                $SendingPackages->updateReceivingPackageSMSStatus($data);
                                $vars['fb_msg'] = "<p class='alert alert-success text-center font-weight-bold'>All SMSs Successfully Sent</p>";
                            } else if (sendSms($data) == 2) {
                                $vars['fb_msg'] = "<p class='alert alert-warning text-center font-weight-bold'>Not All SMSs have been Sent</p>";
                            } else if (sendSms($data) == 0) {
                                $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Error In Sending SMSs</p>";
                            }
                        }
                    } else {
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
                    }
                }
            } else {
                $view_path = "generals/fb_page";
                $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Package Doesn't Exist.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
            }
        } else {
            $view_path = "generals/fb_page";
            $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Please Select a Sent Package.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
        }



        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function receivePackageAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed!</p>";
        $arr_inps_req = [
            "received_date" => "Date Received", "received_time" => "Received Time", "received_package_description" => "Received Package Description",
            "received_package_qty" => "Received Qty", "received_collection_date" => "New Collection Date", "received_collection_time" => "New Collection Time"
        ];
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = array_map('trim', $data);
        $check = checkLenArrVals($arr_inps_req, $data);
        $err_num = 0;
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {
            $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];

            $data["sending_package_status"] = "ARRIVED";
            $data["receiving_packages_status"] = "ARRIVED";
            $SendingPackages = new SendingPackages();
            if ($SendingPackages->addReceivingPackage($data)) {
                $SendingPackages->updateSendingPackageStatus($data);
                $fb_msg_o["matokeo"] = 'success';
                $fb_msg_o["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Package Successfully Received!</p>";
            } else {
                $fb_msg_o["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Something Went Wrong Please Check With Admin!</p>";
            }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
        }

        echo json_encode($fb_msg_o);
    }

    public function collectPackageAction($param_1)
    {
        $vars = [];
        $vars["fb_msg"] = "";
        $vars["action"] = "";
        $SendingPackages = new SendingPackages();
        $view_path = "salesCounter/collectPackage";
        $vars["back_to_1"] = PROOT . "SalesCounter/allSentPackages";
        $arr_display_vals = [
            "receipt_no", "sending_package_status",
            "city_from", "city_to", "to_branch_id", "sender_name", "sender_contacts", "package_description", "package_qty",
            "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time",
            "received_date", "received_time", "received_package_description", "received_package_qty", "received_collection_date", "received_collection_time",
            "collected_date", "collected_time", "collected_by_name", "collected_by_contacts", "collected_by_idno", "collected_by_id_type"
        ];
        if (!empty($param_1) && filter_var($param_1, FILTER_VALIDATE_FLOAT)) {
            $rs_param_1 = $SendingPackages->vOneByPackageId2(["sending_package_id" => $param_1]);
            $rs_param_2 = $SendingPackages->vOneReceivedPackageByPackageId(["sending_package_id" => $param_1]);
            $rs_param_3 = $SendingPackages->vOneCollectedPackageByPackageId(["sending_package_id" => $param_1]);
            //dnd($rs_param_3);
            if (count($rs_param_1)) {
                $Branches = new Branches();
                $vars['rs_bases'] = $Branches->allBases(["order" => " order by base_name asc"]);
                foreach ($arr_display_vals as $vals) {
                    $vars[$vals] = "";
                    if (key_exists($vals, $rs_param_1[0])) {
                        $vars[$vals] = $rs_param_1[0][$vals];
                    }
                    if (count($rs_param_2)) {
                        if (key_exists($vals, $rs_param_2[0])) {
                            $vars[$vals] = $rs_param_2[0][$vals];
                        }
                    }
                    if (count($rs_param_3)) {
                        if (key_exists($vals, $rs_param_3[0])) {
                            $vars[$vals] = $rs_param_3[0][$vals];
                        }
                    }
                    $vars[$vals] = isset($_POST[$vals]) ? $_POST[$vals] : $vars[$vals];
                }
                $vars["rs_branches_to"] = $Branches->vAllByBase(['my_base' => $vars["city_to"]]);
                $vars["sending_package_id"] = $param_1;
                $vars["collected_by_name"] = $rs_param_1[0]["receiver_name"];
                $vars["collected_by_contacts"] = $rs_param_1[0]["receiver_contacts"];
                $sms_sent = count($rs_param_3) ? $rs_param_3[0]["sms_sent"] : 0;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $arr_inps_req = [
                        "city_to" => "City To", "to_branch_id" => "Branch Name", "sender_name" => "Sender Name",
                        "sender_contacts" => "Sender Contacts", "package_description" => "Package Description", "package_qty" => "Package QTY",
                        "package_amount_paid" => "Amount Paid", "date_received" => "Date Received", "time_received" => "Time Received",
                        "receiver_name" => "Receiver Name", "receiver_contacts" => "Receiver Contacts", "collection_date" => "Collection Date",
                        "collection_time" => "Collection Time",
                        "received_date" => "Date Received", "received_time" => "Received Time", "received_package_description" => "Received Package Description",
                        "received_package_qty" => "Received Qty", "received_collection_date" => "New Collection Date", "received_collection_time" => "New Collection Time",
                        "collected_date" => "Date Collected", "collected_time" => "Collected Time", "collected_by_name" => "Collected By",
                        "collected_by_contacts" => "Collected By Contacts", "collected_by_idno" => "Collected By Contacts", "collected_by_id_type" => "Collected By ID Type"
                    ];
                    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $data = array_map('trim', $data);
                    $check = checkLenArrVals($arr_inps_req, $data);
                    $err_num = 0;
                    $num_keys = ["package_amount_paid", "package_qty", "received_package_qty"];
                    foreach ($num_keys as $k) {
                        $data[$k] = str_replace(",", "", $data[$k]);
                        if (trim($data[$k]) == "" || $data[$k] == 0) {
                            $data[$k] = 0;
                        } elseif (!filter_var($data[$k], FILTER_VALIDATE_FLOAT)) {
                            $err_num++;
                            $data["err_num" . $k] = $data[$k];
                        }
                    }
                    if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {
                        /*
                        if (isset($_POST["collect_package"])) {
                            $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];

                            $data["sending_package_status"] = "COLLECTED";
                            $data["receiving_packages_status"] = "COLLECTED";
                            $SendingPackages = new SendingPackages();
                            if ($SendingPackages->addCollectPackage($data)) {
                                $SendingPackages->updateSendingPackageStatus($data);
                                $SendingPackages->updateReceivedPackageStatus($data);
                                $vars["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Package Successfully Collected!</p>";
                            } else {
                                $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Something Went Wrong Please Check With Admin!</p>";
                            }
                        }
                        */
                        if (isset($_POST["send_sms"])) {
                            $rs_collected_package_details = $SendingPackages->vOneCollectedPackageByPackageId($data);
                            $collected_by_name = $rs_collected_package_details[0]["collected_by_name"];
                            $collected_by_contacts = $rs_collected_package_details[0]["collected_by_contacts"];
                            $collected_date = $rs_collected_package_details[0]["collected_date"];
                            $sender_name = $rs_param_1[0]["sender_name"];
                            $receiver_name = $rs_param_1[0]["receiver_name"];
                            $sender_contacts = "255" . ltrim(str_replace(" ", "", $rs_param_1[0]["sender_contacts"]), "0");
                            $receiver_contacts = "255" . ltrim(str_replace(" ", "", $rs_param_1[0]["receiver_contacts"]), "0");
                            $city_from = $rs_param_1[0]["city_from"];
                            $city_to = $rs_param_1[0]["city_to"];
                            $receipt_no = $rs_param_1[0]["receipt_no"];
                            $to_branch_name = $rs_param_1[0]["to_branch_name"];
                            $data["msg"] = "Mzigo Huoo!\n";
                            $data["msg"] .= "From $sender_name ($city_from) To $receiver_name ($city_to) has been Collected By $collected_by_name ($collected_by_contacts) on $collected_date.\nReceipt No: $receipt_no. Thank You For Choosing Us";
                            $data["to"] = [
                                ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                                ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                            ];
                            if ($sms_sent == 0) {
                                if (sendSms($data) == 1) {
                                    $data["sms_sent"] = 1;
                                    $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];
                                    $SendingPackages->updateCollectingPackageSMSStatus($data);
                                    $vars['fb_msg'] = "<p class='alert alert-success text-center font-weight-bold'>All SMSs Successfully Sent</p>";
                                } else if (sendSms($data) == 2) {
                                    $vars['fb_msg'] = "<p class='alert alert-warning text-center font-weight-bold'>Not All SMSs have been Sent</p>";
                                } else if (sendSms($data) == 0) {
                                    $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Error In Sending SMSs</p>";
                                }
                            } else {
                                $vars['fb_msg'] = "<p class='alert alert-warning text-center font-weight-bold'>SMS Already Sent</p>";
                            }
                        }
                    } else {
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
                        $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
                    }
                }
            } else {
                $view_path = "generals/fb_page";
                $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Package Doesn't Exist.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
            }
        } else {
            $view_path = "generals/fb_page";
            $vars['fb_msg'] = "<p class='alert alert-danger text-center font-weight-bold'>Please Select a Sent Package.<br/><br/><a href='" . $vars['back_to_1'] . "'>Click Here To Go to Back</a></p>";
        }



        $this->view->setLayout('layout_main');
        $this->view->render($view_path, $vars);
    }

    public function collectPackageAjaxAction()
    {
        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Action Failed!</p>";
        $arr_inps_req = [
            "collected_date" => "Date Collected", "collected_time" => "Collected Time", "collected_by_name" => "Collected By",
            "collected_by_contacts" => "Collected By Contacts", "collected_by_idno" => "Collected By Contacts", "collected_by_id_type" => "Collected By ID Type"
        ];
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = array_map('trim', $data);
        $check = checkLenArrVals($arr_inps_req, $data);
        $err_num = 0;
        if ($check["submit_form"] == 0 && Tool::checkToken($_POST["csrf_token"]) && $err_num == 0) {
            $data["created_by"] = $data["edited_by"] = $_SESSION["user_id"];

            $data["sending_package_status"] = "COLLECTED";
            $data["receiving_packages_status"] = "COLLECTED";
            $SendingPackages = new SendingPackages();
            if ($SendingPackages->addCollectPackage($data)) {
                $SendingPackages->updateSendingPackageStatus($data);
                $SendingPackages->updateReceivedPackageStatus($data);
                $fb_msg_o["matokeo"] = 'success';
                $fb_msg_o["fb_msg"] = "<p class='alert alert-success font-weight-bold'>Package Successfully Collected!</p>";
            } else {
                $fb_msg_o["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>Something Went Wrong Please Check With Admin!</p>";
            }
        } else {
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] = "<p class='alert alert-danger font-weight-bold'>" . $check["fb_msg"] . "</p>";
            $fb_msg_o["fb_msg"] = $vars["fb_msg"] .= $err_num > 0 ? "<p class='alert alert-danger font-weight-bold'>Please Number Formats!</p> " : "";
        }

        echo json_encode($fb_msg_o);
    }
}