<?php

    class Dao{
        private $host = "us-cdbr-east-02.cleardb.com";
        private $db = "heroku_796c44685342930";
        private $user = "b4df10a438ae9d";
        private $pass = "7f5f3991";

        public function getConnection(){
            try{
                $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
                // echo "Connection created"; //would also put logger here
                return $conn;
            }
            catch(Exception $e){
                //would put logger here
                echo "Failed connection: ". print_r($e, 1);
                exit;
            }
        }
    }


?>