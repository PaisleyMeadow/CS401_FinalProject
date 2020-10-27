<?php

    class User{

        public $id;
        public $fname;
        public $lname;
        public $email;
        public $username;

        public function __construct($id, $email, $username, $fname, $lname, $color){   //initializes user variables

            $this->id = $id;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
            $this->username = $username;
            $this->color = $color;
        }


    };

?>