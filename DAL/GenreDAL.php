<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class GenreDAL {
    public static function create($genre){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO genre(name) VALUES(:name)";
        
        $res=$db->query($query, array(':name'=>$genre->name));
        if($res){
            $genre->id=$db->lastInsertId();
        }
        return($res);
    }
    
    public static function update($genre){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE genre SET name=:name WHERE id_genre=:id_genre";
        
        $res=$db->query($query, array(':name'=>$genre->name, ':id_genre'=>$genre->id));
        
        return($res);
    }
    
    public static function delete($genre){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM genre WHERE id_genre=:id_genre";
        $res=$db->query($query, array(':id_genre'=>$genre->id));
        
        return($res); 
    }
    
    public static function getById($genre){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM genre WHERE id_genre=:id_genre";
        $res=$db->query($query, array(':id_genre' => $genre->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Genre");
        
        $row=$res->fetch();
        if($row){
            $genre->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByName($genre){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM genre WHERE name=:name";
        $res=$db->query($query, array(':name' => $genre->name));
        $res->setFetchMode(PDO::FETCH_CLASS, "Genre");
        
        $row=$res->fetch();
        if($row){
            $genre->copy($row);
        }
        $res->closeCursor();
        return($row);
    }    
}
