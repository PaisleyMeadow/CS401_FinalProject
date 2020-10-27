<?php
    require_once("Logger.php");

    class Dao{
        private $host = "us-cdbr-east-02.cleardb.com";
        private $db = "heroku_796c44685342930";
        private $user = "b4df10a438ae9d";
        private $pass = "7f5f3991";

        private $logger;

        public function __construct(){
            $this->logger = new Logger();
        }

        public function getConnection(){
            try{
                $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
                $this->logger->addLog("Successful connection made");
                return $conn;
            }
            catch(Exception $e){
                
                $this->logger->addLog("Failed connection: ". print_r($e, 1));
                exit();
            }
        }

        /*
            User functions: add, validate(username & password), get
        **/

        public function addUser($user_data)
        {
            $conn = $this->getConnection();

            $insert = "INSERT INTO users
                    (email, username, password, fname, lname)
                    VALUES (?, ?, ?, ?, ?)";

            $query = $conn->prepare($insert);
           
            //bind user data
            $query->bindParam(1, $user_data["register-email"]);
            $query->bindParam(2, $user_data["register-uname"]);
            $query->bindParam(3, $user_data["register-password"]);
            $query->bindParam(4, $user_data["register-fname"]);
            $query->bindParam(5, $user_data["register-lname"]);

            $check = $query->execute();

            $this->logger->addLog("Query Errors:".$query->errorCode());

            return $check;

        }

        public function validateUsername($uname){   //checks to see if username in system (true if exists)

            $conn = $this->getConnection();

            $select = "SELECT * FROM users WHERE username = ?";

            $query = $conn->prepare($select);
            $query->bindParam(1, $uname);

            $query->execute();
            
            if(count($query->fetchAll()) > 0){ $this->logger->addLog("username found");
                return true; 
            }
            $this->logger->addLog("username not found: ".print_r($query->fetchAll(), true));
            return false;
        }

        public function validateEmail($email){ //checks to see if email in system (true if exists)
            
            $conn = $this->getConnection();

            $select = "SELECT * FROM users WHERE email = ?";

            $query = $conn->prepare($select);
            $query->bindParam(1, $email);

            $query->execute();

            if(count($query->fetchAll()) > 0){
                return true;
            }

            return false;
        }

        //validates login and gets user information, returns user data array
        public function getUser($uname, $pw)
        {   
            $conn = $this->getConnection();

            $get = "SELECT * FROM users 
                    WHERE username = ? AND password = ?";

            $query = $conn->prepare($get);
            $query->bindParam(1, $uname);
            $query->bindParam(2, $pw);

            $query->execute();

            $result = $query->fetchAll()[0];
            if(count($result) > 0){
                return $result;
            }
            else{
                return false;
            }
        }

        /*
            Workspace functions
        **/

        public function getWorkspaces($id){  //get all workspaces belonging to user

            $conn = $this->getConnection();

            $get = "SELECT * FROM workspaces WHERE user_id = ?"; 

            $query = $conn->prepare($get);
            $query->bindParam(1, $id);

            $query->execute();

            $result = $query->fetchAll(); 
            if(count($result) > 0){
                return $result;
            }
            else{
                return false;
            }
        }

        // public function 
    }


?>