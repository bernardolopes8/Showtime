<?php

require_once(dirname(__FILE__).'/../DAL/PersonDAL.php');

class Person {
    public $id;
    public $first_name;
    public $last_name;
    public $biography;
    public $birthdate;
    public $country;
    
    public function copy($person){
        $this->id = $person->id_person;
        $this->first_name = $person->first_name;
        $this->last_name = $person->last_name;
        $this->biography = $person->biography;
        $this->birthdate = $person->birthdate;
        $this->country = $person->country_id_country;
    }
    
    public function create(){
        $res=false;
        if(!PersonDAL::getById($this)){
            $res = PersonDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=PersonDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=PersonDAL::delete($this);
        return($res);
    }
    
    public function getById(){
        return(PersonDAL::getById($this));
    }
    
    public function getByNameAndBirthdate(){
        return(PersonDAL::getByNameAndBirthdate($this));
    }
    
    public function getAll(){
        return(PersonDAL::getAll($this));
    }
    
    public function searchByName(){
        return(PersonDAL::searchByName($this));
    }
}