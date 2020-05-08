<?php
    class Session{
        public static function init(){
            if(!isset($_SESSION)) 
                { 
                    session_start(); 
                } 
        }
        public static function set($key, $value){
            $_SESSION[$key] = $value;
        }
        public static function get($key){
            if(isset($_SESSION[$key]))
            {
                return $_SESSION[$key];
            }
            else 
            {
                return false; 
            }
        }
        public static function checkSession(){
            if(self::get("login")==false){
                self::destroy();
                header("Location:login.php");
            }
        }
        public static function checkAdminLogin(){
            self::init();
            if(self::get("login")==false){
                header("Location:login.php");
            }
           
            return true;
           
            
        }
        public static function checkAddStatus(){
            self::init();
            if(self::get("add_status")==true){
                self::init();
                unset($_SESSION['add_status']);
                return true;
            }
            else return false;

        }
        public static function destroy(){
            session_destroy();
            session_unset();
        }
    }

?>