<?php
    class UserObject {
        
        private $user_name = null;
        private $user_password = null;
        private $security_answer1 = null;
        private $security_answer2 = null;
        
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
            $this->user_password = $password;
        }
        
        public function getPassword() {
            return $this->user_password;
        }
        
        public function setSecurityAnswer1($security_answer) {
            $this->security_answer1 = $security_answer;
        }
        
        public function getSecurityAnswer1() {
            return $this->security_answer1;
        }
        
        public function setSecurityAnswer2($security_answer) {
            $this->security_answer2 = $security_answer;
        }
        
        public function getSecurityAnswer2() {
            return $this->security_answer2;
        }
    }
?>