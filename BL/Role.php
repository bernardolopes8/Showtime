<?php

require_once(dirname(__FILE__).'/../DAL/RoleDAL.php');

class Role{
    public $id;
    public $name;
    
    public function copy($role){
        $this->id = $role->id_role;
        $this->name = $role->name;
    }
    
    public function create(){
        $res=false;
        if(!RoleDAL::getById($this)){
            $res = RoleDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=RoleDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=RoleDAL::delete($this);
        return($res);
    }
    
    public function getById(){
        return(RoleDAL::getById($this));
    }
    
    public function getByName(){
        return(RoleDAL::getByName($this));
    }
}