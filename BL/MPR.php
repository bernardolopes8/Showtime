<?php

require_once(dirname(__FILE__).'/../DAL/MPRDAL.php');

class MPR{
    public $movie;
    public $person;
    public $role;  
    
    
     public function copy($mpr){
        $this->movie = $mpr->movie_id_movie;
        $this->person = $mpr->person_id_person;
        $this->role = $mpr->role_id_role;
    }
    
    public function create(){
        $res=false;
        if(!MPRDAL::getByCombination($this)){
            $res = MPRDAL::create($this);
        }
        return($res);
    }
    
    public function update(){
        $res=MPRDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=MPRDAL::delete($this);
        return($res);
    }
    
    public function getByMovie(){
        return(MPRDAL::getByMovie($this));
    }
    
    public function getByPerson(){
        return(MPRDAL::getByPerson($this));
    }
    
    public function getByRole(){
        return(MPRDAL::getByRole($this));
    }
    
    public function getByCombination(){
        return(MPRDAL::getByCombination($this));
    }
}