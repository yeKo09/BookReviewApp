<?php
    class User{
        private $user_id;
        private $username;
        private $user_email;
        private $user_password;
        private $user_firstName;
        private $user_lastName;
        private $user_about;
        private $user_memberSince;
        private $user_from;
        private $user_birthDate;
        private $user_gender;

        function __construct(){
            $user_id = 0;
            $username = "";
            $user_email = "";
            $user_password = "";
            $user_firstName = "";
            $user_lastName = "";
            $user_about = "";
            $user_memberSince = "";
            $user_from = "";
            $user_birthDate = "";
            $user_gender = "";
        }

        public function setID($user_id){
            $this->user_id = $user_id;
        }

        public function getID(){
            return $this->user_id;
        }

        public function setUserName($username){
            $this->username = $username;
        }

        public function getUserName(){
            return $this->username;
        }

        public function setEmail($user_email){
            $this->user_email = $user_email;
        }

        public function getEmail(){
            return $this->user_email;
        }

        public function setPassword($user_password){
            $this->user_password = $user_password;
        }

        public function getPassword(){
            return $this->user_password;
        }

        public function setFirstName($user_firstName){
            $this->user_firstName = $user_firstName;
        }

        public function getFirstName(){
            return $this->user_firstName;
        }

        public function setLastName($user_lastName){
            $this->user_lastName = $user_lastName;
        }

        public function getLastName(){
            return $this->user_lastName;
        }

        public function setAbout($user_about){
            $this->user_about = $user_about;
        }

        public function getAbout(){
            return $this->user_about;
        }

        public function setMemberSince($user_memberSince){
            $this->user_memberSince = $user_memberSince;
        }

        public function getMemberSince(){
            return date("d-m-Y",strtotime($this->user_memberSince));
        }

        public function setFrom($user_from){
            $this->user_from = $user_from;
        }

        public function getFrom(){
            return $this->user_from;
        }

        public function setBirthDate($user_birthDate){
            $this->user_birthDate = $user_birthDate;
        }

        public function getBirthDate(){
            return date("d-m-Y",strtotime($this->user_birthDate));
        }
        
        public function setGender($user_gender){
            $this->user_gender = $user_gender;
        }

        public function getGender(){
            return $this->user_gender;
        }
    }