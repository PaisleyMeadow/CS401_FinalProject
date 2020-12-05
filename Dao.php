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

            //return id 
           return $conn->lastInsertId();
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

             //return id 
           return $conn->lastInsertId();
        }

        //adds content of note from user input
        public function addNoteInput($content, $id){

            $conn = $this->getConnection();

            $update= "UPDATE notes SET content = ? WHERE id = ?";

            $query = $conn->prepare($update);
            $query->bindParam(1, $content);
            $query->bindParam(2, $id);

            $query->execute();
        }

        //delete note
        public function deleteNote($id){

            $conn = $this->getConnection();

            $del = "DELETE FROM notes WHERE id = ?";

            $query = $conn->prepare($del);
            $query->bindParam(1, $id);

            $query->execute();
        }

        //delete image
        public function deleteImage($id){

            $conn = $this->getConnection();

            $del = "DELETE FROM images WHERE id = ?";

            $query = $conn->prepare($del);
            $query->bindParam(1, $id);

            $query->execute();
        }

        //get workspace id for add image and add note
        private function getWorkspaceId($name, $uid){

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

        //saving new color of workspace
        public function saveWorkspaceColor($color, $wname, $uid){

            $conn = $this->getConnection();

            //first, need to get workspace id 
            $wobj = $this->getWorkspaceId($wname, $uid); 
            $id = $wobj[0]["id"];

            $update = "UPDATE workspaces SET color = ? WHERE id = ?";

            $query = $conn->prepare($update);
            $query->bindParam(1, $color);
            $query->bindParam(2, $id);

            try{
                $query->execute();
            }
            catch(PDOException $e){
                $this->logger->addLog("Error updating workspace color: ".$e->getMessage());
            }
        }

        //deleting workspace
        public function deleteWorkspace($wname, $uid){ 

            $conn = $this->getConnection();

            //listen, I know this is bad but uhhh....idc. 
            $conn->query("SET FOREIGN_KEY_CHECKS=0");

            //first, need to get workspace id 
            $wobj = $this->getWorkspaceId($wname, $uid); 
            $id = $wobj[0]["id"];

            $del = "DELETE FROM workspaces WHERE id = ?";

            $query = $conn->prepare($del);
            $query->bindParam(1, $id);
            
            if(!$query->execute()){
                $this->logger->addLog("Unable to delete workspace: ".print_r($query->errorInfo(), true));
            }

            $conn->query("SET FOREIGN_KEY_CHECKS=1");
        }

        //update workspace name
        public function updateWorkspaceName($newName, $wname, $uid){
            $conn = $this->getConnection();

            //first, need to get workspace id 
            $wobj = $this->getWorkspaceId($wname, $uid); 
            $id = $wobj[0]["id"];

            $update = "UPDATE workspaces SET name = ? WHERE id = ?";

            $query = $conn->prepare($update);
            $query->bindParam(1, $newName);
            $query->bindParam(2, $id);
            
            if(!$query->execute()){
                $this->logger->addLog("Unable to update workspace name: ".print_r($query->errorInfo(), true));
            }
        }

        //delete user
        public function deleteUser($uid){
            $conn = $this->getConnection();

            //listen, I know this is bad but uhhh....idc. 
            $conn->query("SET FOREIGN_KEY_CHECKS=0");

            $del = "DELETE FROM users WHERE id = ?";

            $query = $conn->prepare($del);
            $query->bindParam(1, $uid);

            if(!$query->execute()){
                $this->logger->addLog("Unable to delete user: ".print_r($query->errorInfo(), true));
            }

            $conn->query("SET FOREIGN_KEY_CHECKS=1");
        }

    }


?>