<?php

require_once(dirname(__FILE__).'/../DAL/Movie_GenreDAL.php');

class Movie_Genre {
    public $movie;
    public $genre;
    
     public function copy($movie_genre){
        $this->movie = $movie_genre->movie_id_movie;
        $this->genre = $movie_genre->genre_id_genre;
    }
    
    public function create(){
        $res=false;
        if(!Movie_GenreDAL::getByPair($this)){
            $res = Movie_GenreDAL::create($this);
        }
        return($res);
    }
    
    public function delete(){
        $res=Movie_GenreDAL::delete($this);
        return($res);
    }
    
    public function getByMovie(){
        return(Movie_GenreDAL::getByMovie($this));
    }
    
    public function getByGenre(){
        return(Movie_GenreDAL::getByGenre($this));
    }
    
    public function getByPair(){
        return(Movie_GenreDAL::getByPair($this));
    }
}