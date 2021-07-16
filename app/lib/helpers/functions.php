<?php
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'helpers.php');

function checkMTInputsPost($data)
{
    $b = true;
    foreach ($data as $k => $v) {
        if (strlen(trim($v)) == 0) {
            $b = false;
        }
    }
    return $b;
}

function checkMTInputsPost2($data)
{
    $rs = null;
    $rs['submit_form'] = true;
    $rs['check_inp']  = "";
    foreach ($data as $k => $v) {
        if (strlen(trim($v)) == 0) {
            $rs['check_inp'] .= str_replace("_", " ", $k) . '<br/>';
            $rs['submit_form'] = false;
        }
    }
    return $rs;
}

function checkLenPostVals($arr_pos_vals)
{
    $submit_form = 0;
    $fb_msg = "";
    foreach ($arr_pos_vals as $key => $value) {
        if (strlen(trim($_POST[$key])) == 0) {
            $submit_form += 1;
            $fb_msg .= "Please Check " . $value . ".<br/>";
        }
    }
    return ["submit_form" => $submit_form, "fb_msg" => $fb_msg];
}

function checkLenArrVals($arr_vals, $arr)
{
    $submit_form = 0;
    $fb_msg = "";
    foreach ($arr_vals as $key => $value) {
        if (strlen(trim($arr[$key])) == 0) {
            $submit_form += 1;
            $fb_msg .= $submit_form . ". Please Check " . $value . ".<br/>";
        }
    }
    return ["submit_form" => $submit_form, "fb_msg" => $fb_msg];
}


function initializePostVals($arr_initialize_post_vals, $default)
{
    foreach ($arr_initialize_post_vals as $key) {
        ${$key} = isset($_POST[$key]) ? $_POST[$key] : $default;
    }
}


function addDays($date, $days_to_add)
{
    return  date("Y-m-d", strtotime($date . " + " . $days_to_add . " days"));
}

function addDays2($date, $days_to_add, $format)
{
    return  date($format, strtotime($date . " + " . $days_to_add . " days"));
}



function subDays($date, $days_to_sub)
{
    $date = date_create($date);
    date_sub($date, date_interval_create_from_date_string("$days_to_sub days"));
    return date_format($date, "Y-m-d");
}

function checkNumericInputsPost($data)
{
    $rs = null;
    $rs['submit_form'] = true;
    $rs['check_inp']  = "";
    foreach ($data as $k => $v) {

        if (!is_numeric($v)) {
            $rs['check_inp'] .= str_replace("_", " ", $k) . '<br/>';
            $rs['submit_form'] = false;
        }
    }
    return $rs;
}

function checkNumericInputsPostZero($data)
{
    $rs = null;
    $rs['submit_form'] = true;
    $rs['check_inp']  = "";
    foreach ($data as $k => $v) {

        if ($v < 0) {
            $rs['check_inp'] .= str_replace("_", " ", $k) . '<br/>';
            $rs['submit_form'] = false;
        }
    }
    return $rs;
}


function adz_encrypt($data)
{
    $key =    FORMIDABLE_SALT;
    $method =     FORMIDABLE_METHOD;
    $options =     FORMIDABLE_OPTIONS;
    $iv =     FORMIDABLE_IV;
    return openssl_encrypt($data, $method, $key, $options, $iv);
}

function adz_decrypt($encrypted)
{
    $key =    FORMIDABLE_SALT;
    $method =     FORMIDABLE_METHOD;
    $options =     FORMIDABLE_OPTIONS;
    $iv =     FORMIDABLE_IV;
    return openssl_decrypt($encrypted, $method, $key, $options, $iv);
}

function setDataArray($arr)
{
    $output = '';
    foreach ($arr as $k) {
        $output .= '\':' . $k . '\'=>$data[\'' . $k . '\'],' . "\n";
    }
    return ($output);
}

function getDateTimeDiff02($curr_date, $check_date, $unit)
{
    $re = 0;
    $check_date = date_create($check_date);
    $curr_date = date_create($curr_date);
    $day_diff = date_diff($curr_date, $check_date)->format("%a"); //days
    $hr_diff = date_diff($curr_date, $check_date)->format("%h"); //hrs
    $min_diff = date_diff($curr_date, $check_date)->format("%i"); //minutes
    $sec_diff = date_diff($curr_date, $check_date)->format("%s"); //seconds
    $gl = $curr_date >= $check_date ? 1 : -1;
    switch ($unit) {
        case "%a":
            $re = $day_diff;
            break;
        case "%h":
            $re = $day_diff * 24 + $hr_diff;
            break;
        case "%i":
            $re = ($day_diff * 24 + $hr_diff) * 60 + $min_diff;
            break;
        case "%s":
            $re = (($day_diff * 24 + $hr_diff) * 60 + $min_diff) * 60 + $sec_diff;
            break;
        default:
            $re = 0;
    }
    return $re * $gl;
}

function getDateTimeDiff($curr_date, $check_date, $unit)
{
    $chk_bool = true;
    $check_date = date_create($check_date);
    $check_day = $check_date->format("l");
    $check_time = $check_date->format("G:i");
    $curr_date = date_create($curr_date);
    $curr_day = $curr_date->format("l");
    $curr_time = $curr_date->format("G:i");
    $day_diff = date_diff($curr_date, $check_date)->format($unit);
    return $day_diff;
}

function addMins($date_time, $mins_to_add)
{
    return  date("Y-m-d H:i:s", strtotime($date_time . " + " . $mins_to_add . " minutes"));
}

function subMins($date_time, $mins_to_add)
{
    return  date("Y-m-d H:i:s", strtotime($date_time . " - " . $mins_to_add . " minutes"));
}

function addSec($date_time, $val_to_add)
{
    return  date("Y-m-d H:i:s", strtotime($date_time . " + " . $val_to_add . " seconds"));
}

function subSec($date_time, $val)
{
    return  date("Y-m-d H:i:s", strtotime($date_time . " - " . $val . " seconds"));
}

function formNums($num_keys, $arr)
{

    foreach ($num_keys as $k) {
        echo $arr[$k];
        echo "<br/>";
        $arr[$k] = str_replace(",", "", $arr[$k]);
        echo $arr[$k];
        echo "<br/>";
    }
}

function setFormVal($val)
{
    return isset($val) ? "YES" : "NO";
}


function isFormatDate01($date)
{


    if (strpos(trim($date), "-") === false) {
        return false;
    } else {
        list($y, $m, $d) = explode('-', $date);
        return checkdate($m, $d, $y);
    }
}

function isFormatDate02($date)
{


    $dt = DateTime::createFromFormat("Y-m-d", $date);
}

function isFormatDate03($format, $data)
{
    return date_create_from_format("j-M-Y", "15-Mar-2013");
}
//
//

function  inSqlString($arr)
{
    $arr_post_my_base = (explode(",", $arr));
    $post_my_base = "";
    foreach ($arr_post_my_base as $value) {
        $post_my_base .= "'" . Tool::cleanInput($value) . "',";
    }
    return rtrim($post_my_base, ",");
}

function getTZDiff()
{
    $tz = date_default_timezone_get();
    $local_tz = new DateTimeZone('Africa/Dar_es_Salaam');
    $local = new DateTime('now', $local_tz);
    $server_tz = new DateTimeZone($tz);
    $server = new DateTime('now', $server_tz);

    $local_offset = $local->getOffset() / 3600;
    $server_offset = $server->getOffset() / 3600;
    $diff_tz_hrs =  $local_offset - $server_offset;
    return $diff_tz_hrs;
}

function numberTowords($num)
{

    $ones = array(
        0 => "ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
    );
    $tens = array(
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY",
        4 => "FORTY",
        5 => "FIFTY",
        6 => "SIXTY",
        7 => "SEVENTY",
        8 => "EIGHTY",
        9 => "NINETY"
    );
    $hundreds = array(
        "HUNDRED",
        "THOUSAND",
        "MILLION",
        "BILLION",
        "TRILLION",
        "QUARDRILLION"
    ); /*limit t quadrillion */
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr, 1);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {

        while (substr($i, 0, 1) == "0")
            $i = substr($i, 1, 5);
        if ($i < 20) {
            /* echo "getting:".$i; */
            $rettxt .= $ones[$i];
        } elseif ($i < 100) {
            if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
            if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
        } else {
            if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
            if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
            if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
        }
        if ($key > 0) {
            $rettxt .= " " . $hundreds[$key] . " ";
        }
    }
    if ($decnum > 0) {
        $rettxt .= " and ";
        if ($decnum < 20) {
            $rettxt .= $ones[$decnum];
        } elseif ($decnum < 100) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
        }
    }
    return $rettxt;
}

//Function that resizes image.
function resizeImage($SrcImage, $DestImage, $MaxWidth, $MaxHeight, $Quality)
{
    list($iWidth, $iHeight, $type)    = getimagesize($SrcImage);
    $ImageScale              = min($MaxWidth / $iWidth, $MaxHeight / $iHeight);
    $NewWidth                  = ceil($ImageScale * $iWidth);
    $NewHeight                 = ceil($ImageScale * $iHeight);
    $NewCanves                 = imagecreatetruecolor($NewWidth, $NewHeight);

    switch (strtolower(image_type_to_mime_type($type))) {
        case 'image/jpeg':
            $NewImage = imagecreatefromjpeg($SrcImage);
            break;
        case 'image/png':
            $NewImage = imagecreatefrompng($SrcImage);
            break;
        case 'image/gif':
            $NewImage = imagecreatefromgif($SrcImage);
            break;
        default:
            return false;
    }

    // Resize Image
    if (imagecopyresampled($NewCanves, $NewImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $iWidth, $iHeight)) {
        // copy file
        if (imagejpeg($NewCanves, $DestImage, $Quality)) {
            imagedestroy($NewCanves);
            return true;
        }
    }
}


function resizeImage2($SrcImage, $DestImage, $MaxWidth, $MaxHeight, $Quality)
{
    //header('Content-Type: image/jpeg');
    $data = base64_decode($SrcImage);
    $NewImage = imagecreatefromstring($data);
    list($iWidth, $iHeight, $type)    = getimagesize($NewImage);
    $ImageScale              = min($MaxWidth / $iWidth, $MaxHeight / $iHeight);
    $NewWidth                  = ceil($ImageScale * $iWidth);
    $NewHeight                 = ceil($ImageScale * $iHeight);
    $NewCanves                 = imagecreatetruecolor($NewWidth, $NewHeight);



    // Resize Image
    if (imagecopyresampled($NewCanves, $NewImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $iWidth, $iHeight)) {
        // copy file
        if (imagejpeg($NewCanves, $DestImage, $Quality)) {
            imagedestroy($NewCanves);
            return true;
        }
    }
}

function checkLenArrVals2($arr_vals, $arr)
{
    $submit_form = 0;
    $fb_msg = "";
    foreach ($arr_vals as $key => $value) {
        if (gettype($arr[$key]) == "string") {
            if (strlen(trim($arr[$key])) == 0) {
                $submit_form += 1;
                $fb_msg .= $submit_form . ". Please Check " . $value . ".<br/>";
            }
        } else if (gettype($arr[$key]) == "array") {
            if (count($arr[$key]) == 0) {
                $submit_form += 1;
                $fb_msg .= $submit_form . ". Please Check " . $value . ".<br/>";
            }
        }
    }
    return ["submit_form" => $submit_form, "fb_msg" => $fb_msg];
}

function sendSms($data)
{
    $api_key = SMS_API_KEY;
    $secret_key =  SMS_SECRET_KEY;
    $request_id = 0;
    $successful = false;
    $my_success = 0;
    $postData = [
        'source_addr' => 'INFO',
        'encoding' => 0,
        'schedule_time' => '',
        'message' => $data["msg"],
        'recipients' =>
        $data["to"]

    ];

    $Url = 'https://apisms.beem.africa/v1/send';

    $ch = curl_init($Url);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
            'Content-Type: application/json'
        ),
        CURLOPT_POSTFIELDS => json_encode($postData)
    ));

    $response = curl_exec($ch);

    if ($response === FALSE) {
        //echo $response;

        //  die(curl_error($ch));
    } else {
        $decoded_data = json_decode($response);
        if (property_exists($decoded_data, "code")) {
            $code = $decoded_data->code;
            if ($code == 100) {
                $my_success = 2;
                $valid = $decoded_data->valid;
                if ($valid == count($data["to"])) {
                    $my_success = 1;
                    $successful = $decoded_data->successful;
                    $request_id = $decoded_data->request_id;
                }
            }
        }
    }
    return $my_success;
}