<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class WatchlistDAL {
    public static function create($watchlist){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO watchlist(user_id_user, movie_id_movie) VALUES(:user, :movie)";
        
        $res=$db->query($query, array(':user'=>$watchlist->user, ':movie'=>$watchlist->movie));
        return($res);
    }
    
    public static function delete($watchlist){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM watchlist WHERE user_id_user=:user AND movie_id_movie=:movie";
        $res=$db->query($query, array(':user'=>$watchlist->user, ':movie'=>$watchlist->movie));
        
        return($res); 
    }
    
    public static function getByUser($watchlist){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM watchlist WHERE user_id_user=:user";
        $res=$db->query($query, array(':user' => $watchlist->user));
        $res->setFetchMode(PDO::FETCH_CLASS, "Watchlist");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
    
    public static function getByUserAndMovie($watchlist){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM watchlist WHERE movie_id_movie=:movie AND user_id_user=:user";
        $res=$db->query($query, array(':user' => $watchlist->user, ':movie' => $watchlist->movie));
        $res->setFetchMode(PDO::FETCH_CLASS, "Watchlist");
        
        $row=$res->fetch();
        $res->closeCursor();
        return($row);
    }
}

