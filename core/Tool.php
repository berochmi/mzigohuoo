<?php

class Tool
{
    public static function csvMarker03($query, $keys_vals, $DocName)
    {
        ob_start();
        $DocName .= date("_Y-m-d", time());
        header("Content-type: application/vnd.ms-excel");
        header("Content-Encoding: UTF-8");
        header('Content-Type: application/csv');
        header("Content-type: text/csv; charset=UTF-8");
        header("Content-type:text/octect-stream");
        header("Content-Disposition:attachment;filename=$DocName.csv");
        ob_end_clean(); // to remove html when exporting to CSV
        $keys = array_keys($keys_vals);
        $head = array_values($keys_vals);
        print '"' . stripslashes(implode('","', $head)) . "\"\n";

        for ($i = 0; $i < count($query); $i++) {
            $print = null;
            foreach ($keys as $key) {
                $print .= stripslashes($query[$i][$key] . '","');
            }
            print '"' . $print . "\"\n";
        }
        exit();
    }

    public static function cleanInput($input)
    {
        $input = trim(strip_tags($input, ","));
        $input = stripslashes($input);
        return $input;
    }

    public static function generateToken(){
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function checkToken($token){
        return (isset($_SESSION['csrf_token']) &&  $_SESSION['csrf_token'] == $token);
    }
    public static function csrfInput(){
      return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generateToken().'" />';
    }
    
    public static function setDisplayVal($input){
        return isset($input)?$input:"";
    }

}
