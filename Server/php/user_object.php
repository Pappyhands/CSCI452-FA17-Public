<?php
    class UserObject {
        
        private $user_id = null;
        private $user_password = null;
        private $security_answer1 = null;
        private $security_answer2 = null;
        private $email = null;
        
        public function __construct($id, $email, $pass, $answer1, $answer2) {
            $this->setID($id);
            $this->setPassword($pass);
            $this->setSecurityAnswer1($answer1);
            $this->setSecurityAnswer2($answer2);
            $this->setEmail($email);
        }
        public function setEmail($email) {
            $this->email = $email;
        }
        
        public function getEmail() {
            return $this->email;
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
        
        public function setID($id) {
            $this->user_id = $id;
        }
        
        public function getID() {
            return $this->user_id;
        }
    }
?>