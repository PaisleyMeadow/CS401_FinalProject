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

        public function getElements($wid){  //get all elements belong to that workspace

            $elements = array();

            $elements["images"] = $this->getImages($wid);
            $elements["notes"] = $this->getNotes($wid);
            $elements["videos"] = $this->getVideos($wid);

            return $elements;
        }

        public function getImages($wid){
            return $this->get("images", "workspace_id", $wid);
        }

        public function getNotes($wid){
            return $this->get("notes", "workspace_id", $wid);
        }

        public function getVideos($wid){
            return $this->get("videos", "workspace_id", $wid);
        }

        //generic select * from table, takes in table name, column name to match, and data to look for
        public function get($table, $column, $data){  
            
            $conn = $this->getConnection();

            $get = "SELECT * FROM ".$table." WHERE ".$column." = ?"; 

            $query = $conn->prepare($get);
            $query->bindParam(1, $data);

            $query->execute(); 

            $result = $query->fetchAll(); 
            if(count($result) > 0){
                return $result;
            }
            else{
                return false;
            }
        }

        //adds new workspace
        public function addWorkspace($name, $color, $uid){

            //validates name doesn't already exist in table 
            if($this->validateWorkspace($name, $uid)){
                return false;
            }

            $conn = $this->getConnection();

            if($color == ""){
                $color = "fdf0d5";
            }
        
            $insert = "INSERT INTO workspaces
                (name, color, user_id)
                VALUES (?, ?, ?)";
        
            $query = $conn->prepare($insert);
           
            //bind user data
            $query->bindParam(1, $name);
            $query->bindParam(2, $color);
            $query->bindParam(3, $uid);
        
            $check = $query->execute();

            $this->logger->addLog("Query Errors:".$query->errorCode());

            return $check;
        }

        //validates workspace name is unique (true if exists)
        public function validateWorkspace($name, $uid){
            
            $conn = $this->getConnection();

            $get = "SELECT * FROM workspaces WHERE name = ? AND user_id = ?"; 

            $query = $conn->prepare($get);
            $query->bindParam(1, $name);
            $query->bindParam(2, $uid);

            $query->execute(); 

            $result = $query->fetchAll(); 
            if(count($result) > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function addImage($path, $url, $wname, $uid){

            //first, need to get workspace id 
            $wobj = $this->getWorkspaceId($wname, $uid); 
            $id = $wobj[0]["id"];

            $conn = $this->getConnection();

            $insert = "INSERT INTO images
                (location, url, workspace_id)
                VALUES (?, ?, ?)";
        
            $query = $conn->prepare($insert);
           
            //bind user data
            $query->bindParam(1, $path);
            $query->bindParam(2, $url);
            $query->bindParam(3, $id);
        
            $check = $query->execute();

            $this->logger->addLog("Query Errors:".$query->errorCode());
        }

        public function addNote($color, $wname, $uid){

            //first, need to get workspace id 
            $wobj = $this->getWorkspaceId($wname, $uid); 
            $id = $wobj[0]["id"];

            $conn = $this->getConnection();

            $insert = "INSERT INTO notes
                (color, workspace_id)
                VALUES (?, ?)";
        
            $query = $conn->prepare($insert);
           
            //bind user data
            $query->bindParam(1, $color);
            $query->bindParam(2, $id);
        
            $check = $query->execute();

            $this->logger->addLog("Query Errors:".$query->errorCode());
        }

        public function getWorkspaceId($name, $uid){

            $conn = $this->getConnection();

            $get = "SELECT * FROM workspaces WHERE name = ? AND user_id = ?"; 

            $query = $conn->prepare($get);
            $query->bindParam(1, $name);
            $query->bindParam(2, $uid);

            $query->execute(); 

            $result = $query->fetchAll(); 
            if(count($result) > 0){
                return $result;
            }
            else{
                return false;
            }

        }
    }


?>