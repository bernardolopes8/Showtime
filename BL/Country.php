<?php

require_once(dirname(__FILE__).'/../DAL/CountryDAL.php');

class Country {
    public $id;
    public $name;
    
    public function copy($country){
        $this->id = $country->id_country;
        $this->name = $country->name;
    }
    
    public function create(){
        $res=false;
        if(!CountryDAL::getById($this)){
            $res = CountryDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=CountryDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=CountryDAL::delete($this);
        return($res);
    }
    
    public function getById(){
        return(CountryDAL::getById($this));
    }
    
    public function getByName(){
        return(CountryDAL::getByName($this));
    }
    
    public function getAll(){
        return(countryDAL::getAll($this));
    }  
}

