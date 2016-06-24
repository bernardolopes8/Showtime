<?php

require_once(dirname(__FILE__).'/../DAL/GenreDAL.php');

class Genre{
    public $id;
    public $name;
    
    public function copy($genre){
        $this->id = $genre->id_genre;
        $this->name = $genre->name;
    }
    
    public function create(){
        $res=false;
        if(!GenreDAL::getById($this)){
            $res = GenreDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=GenreDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=GenreDAL::delete($this);
        return($res);
    }
    
    public function getById(){
        return(GenreDAL::getById($this));
    }
    
    public function getByName(){
        return(GenreDAL::getByName($this));
    }
}

