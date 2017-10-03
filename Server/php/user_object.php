<?php
    class UserObject {
        
        private $user_name = "defaultname";
        private $user_password = "defaultpassword";
        
        public function __construct($name, $pass) {
            $this->user_name = $name;
            $this->user_password = $pass;
        }
        
        public function setName($name) {
            $this->user_name = $name;
        }
        
        public function getName() {
            return $this->user_name;
        }
        
        public function setPassword($password) {
            $this->user_password = $password;
        }
        
        public function getPassword() {
            return $this->user_password;
        }
        
        // // Update user table in the database
        // public function updateUserObject() {
            
        // }
    }
?>