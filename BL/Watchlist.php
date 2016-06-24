<?php

require_once(dirname(__FILE__).'/../DAL/WatchlistDAL.php');

class Watchlist{
    public $user;
    public $movie;
    
    public function copy($watchlist){
        $this->user = $watchlist->user_id_user;
        $this->movie = $watchlist->movie_id_movie;
    }
    
    public function create(){
        $res=false;
        if(!WatchlistDAL::getByUserAndMovie($this)){
            $res = WatchlistDAL::create($this);
        } 
        return($res);
    }
    
    public function delete(){
        $res=WatchlistDAL::delete($this);
        return($res);
    }
    
    public function getByUser(){
        return(WatchlistDAL::getByUser($this));
    }
    
    public function getByUserAndMovie(){
        return(WatchlistDAL::getByUserAndMovie($this));
    }
}