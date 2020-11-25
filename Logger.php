<?php
// very basic logger that makes (daily) a file in the logs directory
// and prints debugging and error logs to it

class Logger{

    private $filepath; 
    private $logfile;

    public function __construct(){

        //opens file if already created or creates it
        $this->filepath = "logs/".date("Y-m-d")."_log.txt";
        $this->logfile = fopen($this->filepath, "a") or die ("Unable to open file.");
    }

    public function addLog($message){

        $date = date("h:i:sa");
        if(fwrite($this->logfile, $date." : ".$message."\n") == false){
            echo "Failed to write to file.";
        }
    }

};

?>