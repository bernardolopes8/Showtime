<?php

require_once(dirname(__FILE__)."/../DAL/MovieDAL.php");

class Movie {
    public $id;
    public $title;
    public $synopsys;
    public $runtime;
    public $release_date;
    public $trailer;
    public $country;
    public $company;
    public $rating;
    
    public function copy($movie){
        $this->id = $movie->id_movie;
        $this->title = $movie->title;
        $this->synopsys = $movie->synopsys;
        $this->runtime = $movie->runtime;
        $this->release_date = $movie->release_date;
        $this->trailer = $movie->trailer;
        $this->country = $movie->country_id_country;
        $this->company = $movie->company_id_company;
        $this->rating = $movie->rating;
    }
    
    public function create(){
        $res=false;
        if(!MovieDAL::getById($this)){
            $res = MovieDAL::create($this);
        } 
        return($res);
    }
    
    public function update(){
        $res=MovieDAL::update($this);
        return($res);
    }
    
    public function delete(){
        $res=MovieDAL::delete($this);
        return($res);
    }
    
    public function getByTitle(){
        return(MovieDAL::getByTitle($this));
    }
    
    public function getById(){
        return(MovieDAL::getById($this));
    }
    
    public function getAll(){
        return(MovieDAL::getAll());
    }
    
    public function searchByTitle(){
        return(MovieDAL::searchByTitle($this));
    }
}

