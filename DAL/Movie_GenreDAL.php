<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class Movie_GenreDAL {
    public static function create($movie_genre){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO movie_genre(movie_id_movie, genre_id_genre) VALUES(:movie, :genre)";
        
        $res=$db->query($query, array(':movie'=>$movie_genre->movie, ':genre'=>$movie_genre->genre));
        return($res);
    }
    
    public static function delete($movie_genre){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM movie_genre WHERE movie_id_movie=:movie AND genre_id_genre=:genre";
        $res=$db->query($query, array(':movie'=>$movie_genre->movie, ':genre'=>$movie_genre->genre));
        
        return($res); 
    }
    
    public static function getByGenre($movie_genre){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_genre WHERE genre_id_genre=:genre";
        $res=$db->query($query, array(':genre' => $movie_genre->genre));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie_Genre");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
    
    public static function getByMovie($movie_genre){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_genre WHERE movie_id_movie=:movie";
        $res=$db->query($query, array(':movie' => $movie_genre->movie));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie_Genre");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
    
    public static function getByPair($movie_genre){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_genre WHERE movie_id_movie=:movie AND genre_id_genre=:genre";
        $res=$db->query($query, array(':movie' => $movie_genre->movie, ':genre' => $movie_genre->genre));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie_Genre");
        
        $row=$res->fetch();
        $res->closeCursor();
        return($row);
    }
}

