<?php
    class UserObject {
        
        private $user_name = "defaultname";
        private $user_password = "defaultpassword";
        private $security_answer1 = "defaultanswer1";
        private $security_answer2 = "defaultanswer2";
        
        public function __construct($name, $pass, $answer1, $answer2) {
            $this->setName($name);
            $this->setPassword($pass);
            $this->setSecurityAnswer1($answer1);
            $this->setSecurityAnswer2($answer2);
        }
        
        public function setName($name) {
            $this->user_name = $name;
        }
        
        public function getName() {
            return $this->user_name;
        }
        
        public function setPassword($password) {
            $this->user_password = password_hash($password, PASSWORD_DEFAULT);
        }
        
        public function getPassword() {
            return $this->user_password;
        }
        
        public function setSecurityAnswer1($security_answer) {
            $this->security_answer1 = password_hash($security_answer, PASSWORD_DEFAULT);
        }
        
        public function getSecurityAnswer1() {
            return $this->security_answer1;
        }
        
        public function setSecurityAnswer2($security_answer) {
            $this->security_answer2 = password_hash($security_answer, PASSWORD_DEFAULT);
        }
        
        public function getSecurityAnswer2() {
            return $this->security_answer2;
        }
    }
?>