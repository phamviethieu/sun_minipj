<?php
    $cookie_name = "loginInfor";
    class Cookie{
        public static function exists($name){
            return (isset($_COOKIE[$name])) ? true : false;
        }
        public static function set($name, $val, $exp){
            if(setcookie($name, $val, time() + $exp)){
                return true;
            }
            return false;
        } 
        public static function get($name){
            if (isset ($_COOKIE[$name])){
                return $_COOKIE[$name];
            }
            else return false;
        }
        public static function destroy($name){
            self::set($name,'',time() - 3600 * 24 * 100);
        }
    }
    // Cookie::destroy("loginInfor");

?>