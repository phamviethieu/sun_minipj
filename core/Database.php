<?php
    $filepath = realpath(dirname(__FILE__));

    include_once($filepath.'/../lib/Session.php');
    include_once($filepath.'/../config.php');

    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASS;
        private $database = DB_NAME;
        private $charset = "utf8";
        private $con;
        private $error;
    
        public function __construct(){
            $this->connect();
        }
        public function connect(){
            try {
                $this->con = new mysqli($this->host, $this->user, $this->password, $this->database);
            } catch (Exception $e){
                echo $e->getMessage();
            }
            // if(!$this->con){
            //     $this->error = "Failed to connect error".$this->con->connect_error;
            //     return false;
            // }
        }
        public function disconnect(){
            if($this->con){
                mysqli_close($this->con);
            }
        }
        public function select($query){
            $this->connect();
            if($result = mysqli_query($this->con,$query)){
                while($row = mysqli_fetch_object($result)){
                    $data[] = $row;
                }
                mysqli_free_result($result);
                if(isset($data)){
                    return $data;
                }
                
            }
        }
        public function insert($query){
            $insert_row = $this->con->query($query) or die($this->con->error.__LINE__);
            if($insert_row){
                return $insert_row;
            }
            else {
                return false;
            }
        }
        public function update($query){
            $update_row = $this->con->query($query) or die($this->con->error.__LINE__);
            if($update_row){
                return $update_row;
            }
            else return false;
        }
        public function delete($query){
            $delete_row = $this->con->query($query) or die($this->con->error.__LINE__);
            if($delete_row){
                return $delete_row;
            }
            else return false;
        }
    }
   
 

?>