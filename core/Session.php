<?php
class Session
{
  public static function checkActivity()
  {

    if (isset($_SESSION['login_time'])) {
      //1800
      if (time() - $_SESSION['login_time'] > LOGGED_TIME_OUT) {
        self::logOut();
        Router::redirect("login/index");
      } else {
        self::setLoginTime();
        //return true;
      }
    }
  }

  public static function setLoginTime()
  {
    $_SESSION['login_time'] = time();
  }

  public static function logOut()
  {
    unset($_SESSION['search_inp']);
    $_SESSION['search_inp'] = "";
    $_SESSION['user_id'] = "";
    $_SESSION['username'] = "";
    $_SESSION['role'] = "";
    unset($_SESSION['username']);
    $_SESSION = [];

    //session_unset();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 42000);
    }
    session_destroy();
  }

  public static function isLoggedIn($session_id)
  {
    return isset($session_id);
  }

  public static function njeNdani()
  {
    if (isset($_SESSION['username'])) {
      if (empty($_SESSION['username'])) {
        self::logOut();
        Router::redirect("login/index");
      } else {
        self::checkActivity();
      }
    } 
  }

  public static function startSession()
  {
    session_start();
    //session_regenerate_id(true);

  }

  public static function checkUsername(){
    $_SESSION['username'] = isset($_SESSION['username'])?$_SESSION['username']:"";
  }
 
  
}
