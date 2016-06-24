<?php

require_once(dirname(__FILE__).'/../DAL/UserDAL.php');

class User {
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $birthdate;
    public $type; // Admin - 0; User - 1
    public $country;
    
    public function isAdmin() {
        $ret = false;
        if ($this->type == 0) {
            $ret = true;
        }
        return $ret;
    }
    
    public function copy($user){
        $this->id = $user->id_user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->birthdate = $user->birthdate;
        $this->type = $user->type;
        $this->country = $user->country_id_country;
    }
    
    public function __construct() {
    }
    
    public function create(){
        $res=false;
        if(!UserDAL::getById($this)){
            $res = UserDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=UserDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=UserDAL::delete($this);
        return($res);
    }
    
    public function getById(){
        return(UserDAL::getById($this));
    }
    
    public function getByUsername(){
        return(UserDAL::getByUsername($this));
    }
    
    public function getByEmail(){
        return(UserDAL::getByEmail($this));
    }
    
    public function getByEmailAndPassword() {
        return(UserDAL::getByEmailAndPassword($this));
    }
    
    public function getAdmins() {
        return(UserDAL::getAdmins());
    }
}

