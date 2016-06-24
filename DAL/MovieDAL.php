<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class MovieDAL {
    public static function create($movie){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO movie(title, synopsys, runtime, release_date, trailer, rating, country_id_country, company_id_company) "
                . "VALUES(:title, :synopsys, :runtime, :release_date, :trailer, :rating, :country_id_country, :company_id_company)";
        
        $res=$db->query($query, array(':title'=>$movie->title, ':synopsys'=>$movie->synopsys, ':runtime'=>$movie->runtime,
            ':release_date'=>$movie->release_date, ':trailer'=>$movie->trailer, ':rating'=>$movie->rating, ':country_id_country'=>$movie->country, ':company_id_company'=>$movie->company));
        if($res){
            $movie->id=$db->lastInsertId(); 
        }
        return($res);
    }
    
    public static function update($movie){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE movie SET title=:title, synopsys=:synopsys, runtime=:runtime, release_date=:release_date, trailer=:trailer, rating=:rating,"
                . " country_id_country=:country_id_country, company_id_company=:company_id_company WHERE id_movie=:id";
        
        $res=$db->query($query, array(':title'=>$movie->title, ':synopsys'=>$movie->synopsys, ':runtime'=>$movie->runtime, ':release_date'=>$movie->release_date,
             ':trailer'=>$movie->trailer, ':rating'=>$movie->rating, ':country_id_country'=>$movie->country, ':company_id_company'=>$movie->company, ':id'=>$movie->id));
        
        return($res);
    }
    
    public static function delete($movie){
        
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM movie WHERE id_movie=:id";
        $res=$db->query($query, array(':id'=>$movie->id));
        
        return($res);
    }
    
    public static function getAll(){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie";
        
        $res = $res=$db->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie");
        
        return($res);
    }
    
    public static function getByTitle($movie){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie WHERE title=:title";
        $res=$db->query($query, array(':title' => $movie->title));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie");
        
        $row=$res->fetch();
        if($row){
            $movie->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getById($movie){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie WHERE id_movie=:id";
        $res=$db->query($query, array(':id' => $movie->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie");
        
        $row=$res->fetch();
        if($row){
            $movie->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function searchByTitle($movie){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie WHERE title LIKE concat('%', :title, '%')";
        $res=$db->query($query, array(':title' => $movie->title));
        $res->setFetchMode(PDO::FETCH_CLASS, "Movie");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
}