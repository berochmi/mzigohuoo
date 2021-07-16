<?php

class LoginController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction()
    {
        //$this->view->setLayout('layout_main');
        $User = new Users();
        $ok = false;
        $vars['fb_msg'] = "";

        if (isset($_POST['login'])) {
            $ok = $User->loginUser($_POST);

            if ($ok) {
                $rs_user_details = $User->selectUsername2($_POST);
                $_SESSION["username"] = $rs_user_details[0]["username"];
                $_SESSION["user_id"]  = $rs_user_details[0]["user_id"];
                $_SESSION["my_branch_id"]  = $rs_user_details[0]["my_branch_id"];
                $_SESSION["role"]  = $rs_user_details[0]["user_group_name"];
                $_SESSION['my_base'] = $rs_user_details[0]["my_base"];
                //dnd($rs_user_details);
                Session::setLoginTime();

                switch (strtolower($_SESSION["role"])) {

                    case 'sales':

                        Router::redirect("SalesCounter");
                        break;
                    case 'admin':

                        Router::redirect("SalesCounter");
                        break;
                    default:

                        $vars['fb_msg'] = "<p class=' alert alert-danger font-weight-bold text-center'>You Don't Have The Right Permissions! </p>";
                        break;
                }
            } else {
                $vars['fb_msg'] = '<p style="text-align: center;" class="alert alert-danger">Wrong Username or Password</p>';
            }
        }
        $this->view->setLayout('l_login');
        $this->view->render('login/index', $vars);
    }


    public function runSetUpAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $User = new Users();
        $ok = false;

        $ok = $User->loginUser($decoded_data);
        if ($ok) {

            $rs_user_details = $User->selectUsername2($decoded_data);
            $fb_msg_o["rs_user_details"] = $rs_user_details;
            Session::setLoginTime();

            switch (strtolower($rs_user_details[0]["user_group_name"])) {

                case 'admin':
                    $fb_msg_o["matokeo"] = 'success';

                    break;
                default:

                    $fb_msg_o['fb_msg'] = "You Don't Have The Right Permissions!";
            }
        } else {
            $fb_msg_o['fb_msg'] = 'Wrong Username or Password!';
        }

        //$encoded_data = file_get_contents("php://input");
        //$decoded_data = json_decode($encoded_data,true);
        //$rs_errrands = $Errands->vErrandsByAssignedUserName(["assigned_to_username"=>"admin"]);
        //$fb_msg_o["rs_errrands"] = $rs_errrands;

        echo json_encode($fb_msg_o);
    }

    public function runScanPackageAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = 'Action Failed!';
        $SendingPackages = new SendingPackages();
        $fb_msg_o["decoded_data"] = $decoded_data;
        $fb_msg_o["rs_package_details"] = $SendingPackages->vOneByReceiptNo($decoded_data);
        if (count($fb_msg_o["rs_package_details"])) {
            $fb_msg_o["matokeo"] = 'success';
        } else {
            $fb_msg_o["fb_msg"] = "Sorry Code Doesn't Exist!";
        }

        echo json_encode($fb_msg_o);
    }

    public function runTransitPackageAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = 'Action Failed!';
        $SendingPackages = new SendingPackages();
        $fb_msg_o["decoded_data"] = $decoded_data;
        $rs_package_details = $SendingPackages->vOneByReceiptNo($decoded_data);
        if (count($rs_package_details)) {
            $decoded_data["sending_package_status"] = "IN TRANSIT";
            if ($SendingPackages->updateSendingPackageStatusByReceiptNo($decoded_data)) {
                $fb_msg_o["matokeo"] = 'success';
                $sender_name = $rs_package_details[0]["sender_name"];
                $receiver_name = $rs_package_details[0]["receiver_name"];
                $sender_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["sender_contacts"]), "0");
                $receiver_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["receiver_contacts"]), "0");
                $city_from = $rs_package_details[0]["city_from"];
                $city_to = $rs_package_details[0]["city_to"];
                $receipt_no = $rs_package_details[0]["receipt_no"];
                $data["msg"] = "Mzigo Huoo!\n";
                $data["msg"] .= "From $sender_name ($city_from) To $receiver_name ($city_to) is IN TRANSIT.\nReceipt No: $receipt_no";
                $data["to"] = [
                    ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                    ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                ];
                sendSms($data);
            }
        }

        echo json_encode($fb_msg_o);
    }

    public function runReceivePackageAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = 'Action Failed!';
        $SendingPackages = new SendingPackages();
        $fb_msg_o["decoded_data"] = $decoded_data;
        $rs_package_details = $SendingPackages->vOneByReceiptNo($decoded_data);

        if (count($rs_package_details)) {
            $decoded_data["sending_package_id"] = $rs_package_details[0]["sending_package_id"];
            $decoded_data["received_date"] = date("Y-m-d");
            $decoded_data["received_time"] = date("H:i");
            $decoded_data["received_collection_date"] = $rs_package_details[0]["collection_date"];
            $decoded_data["received_collection_time"] = $rs_package_details[0]["collection_time"];
            $decoded_data["receiving_packages_status"] = "ARRIVED";
            $decoded_data["sending_package_status"] = "ARRIVED";
            $SendingPackages = new SendingPackages();
            if ($SendingPackages->addReceivingPackage($decoded_data)) {
                $SendingPackages->updateSendingPackageStatus($decoded_data);
                $fb_msg_o["matokeo"] = 'success';
                $fb_msg_o["fb_msg"] = "Package Successfully Received!";
                $sender_name = $rs_package_details[0]["sender_name"];
                $receiver_name = $rs_package_details[0]["receiver_name"];
                $sender_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["sender_contacts"]), "0");
                $receiver_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["receiver_contacts"]), "0");
                $city_from = $rs_package_details[0]["city_from"];
                $city_to = $rs_package_details[0]["city_to"];
                $receipt_no = $rs_package_details[0]["receipt_no"];
                $to_branch_name = $rs_package_details[0]["to_branch_name"];
                $data["msg"] = "Mzigo Huoo!\n";
                $data["msg"] .= "From $sender_name ($city_from) To $receiver_name ($city_to) has ARRIVED. Please Collect Package at $to_branch_name.\nReceipt No: $receipt_no";
                $data["to"] = [
                    ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                    ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                ];
                //dnd($data);
                //sendSms($data);
                if (sendSms($data) == 1) {
                    $data["sending_package_id"] = $decoded_data["sending_package_id"];
                    $data["sms_sent"] = 1;
                    $data["created_by"] = $data["edited_by"] = $decoded_data["created_by"];
                    $SendingPackages->updateReceivingPackageSMSStatus($data);
                }
            } else {
                $fb_msg_o["fb_msg"] = "Something Went Wrong Please Check With Admin!";
            }
        }

        echo json_encode($fb_msg_o);
    }

    public function downloadAllPackagesAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = 'Action Failed!';
        $SendingPackages = new SendingPackages();
        $fb_msg_o["decoded_data"] = $decoded_data;
        $fb_msg_o["rs_all_packages"] = $SendingPackages->vAllInProgress();
        if (count($fb_msg_o["rs_all_packages"])) {
            $fb_msg_o["matokeo"] = 'success';
        }

        echo json_encode($fb_msg_o);
    }

    public function runCollectPackageAction()
    {
        header('Access-Control-Allow-Origin: *');
        $encoded_data = file_get_contents("php://input");
        $decoded_data = json_decode($encoded_data, true);

        $fb_msg_o["matokeo"] = 'failed';
        $fb_msg_o["fb_msg"] = 'Action Failed!';
        $SendingPackages = new SendingPackages();
        $fb_msg_o["decoded_data"] = $decoded_data;
        $rs_package_details = $SendingPackages->vOneByReceiptNo($decoded_data);

        if (count($rs_package_details)) {
            $decoded_data["sending_package_id"] = $rs_package_details[0]["sending_package_id"];
            $decoded_data["collected_date"] = date("Y-m-d");
            $decoded_data["collected_time"] = date("H:i");
            $decoded_data["receiving_packages_status"] = "COLLECTED";
            $decoded_data["sending_package_status"] = "COLLECTED";
            $SendingPackages = new SendingPackages();
            if ($SendingPackages->addCollectPackage($decoded_data)) {
                $SendingPackages->updateSendingPackageStatus($decoded_data);
                $SendingPackages->updateReceivedPackageStatus($decoded_data);
                $rs_collected_package_details = $SendingPackages->vOneCollectedPackageByPackageId($decoded_data);
                $collected_by_name = $rs_collected_package_details[0]["collected_by_name"];
                $collected_by_contacts = $rs_collected_package_details[0]["collected_by_contacts"];
                $collected_date = $rs_collected_package_details[0]["collected_date"];
                $sender_name = $rs_package_details[0]["sender_name"];
                $receiver_name = $rs_package_details[0]["receiver_name"];
                $sender_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["sender_contacts"]), "0");
                $receiver_contacts = "255" . ltrim(str_replace(" ", "", $rs_package_details[0]["receiver_contacts"]), "0");
                $city_from = $rs_package_details[0]["city_from"];
                $city_to = $rs_package_details[0]["city_to"];
                $receipt_no = $rs_package_details[0]["receipt_no"];
                $to_branch_name = $rs_package_details[0]["to_branch_name"];
                $data["msg"] = "Mzigo Huoo!\n";
                $data["msg"] .= "From $sender_name ($city_from) To $receiver_name ($city_to) has been Collected By $collected_by_name ($collected_by_contacts) on $collected_date.\nReceipt No: $receipt_no. Thank You For Using Our Services!";
                $data["to"] = [
                    ['recipient_id' => '1', 'dest_addr' => $sender_contacts],
                    ['recipient_id' => '2', 'dest_addr' => $receiver_contacts]
                ];
                //dnd($data);
                //sendSms($data);
                if (sendSms($data) == 1) {
                    $data["sending_package_id"] = $decoded_data["sending_package_id"];
                    $data["sms_sent"] = 1;
                    $data["created_by"] = $data["edited_by"] = $decoded_data["created_by"];
                    $SendingPackages->updateCollectingPackageSMSStatus($data);
                }


                $fb_msg_o["matokeo"] = 'success';
                $fb_msg_o["fb_msg"] = "Package Successfully Collected!";
            } else {
                $fb_msg_o["fb_msg"] = "Something Went Wrong Please Check With Admin!";
            }
        }

        echo json_encode($fb_msg_o);
    }
}