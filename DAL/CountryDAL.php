<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class CountryDAL {
    
    public static function create($country){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO country(name) VALUES(:name)";
        
        $res=$db->query($query, array(':name'=>$country->name));
        if($res){
            $country->id=$db->lastInsertId();
        }
        return($res);
    }
    
    public static function update($country){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE country SET name=:name WHERE id_country=:id";
        
        $res=$db->query($query, array(':name'=>$country->name, ':id'=>$country->id));
        
        return($res);
    }
    
    public static function delete($country){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM country WHERE id_country=:id";
        $res=$db->query($query, array(':id'=>$country->id));
        
        return($res);
    }
    
    public static function getById($country){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM country WHERE id_country=:id_country";
        $res=$db->query($query, array(':id_country'=>$country->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Country");
        
        $row=$res->fetch();
        if($row){
            $country->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByName($country){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM country WHERE name=:name";
        $res=$db->query($query, array(':name'=>$country->name));
        $res->setFetchMode(PDO::FETCH_CLASS, "Country");
        
        $row=$res->fetch();
        if($row){
            $country->copy($row);
        }
        $res->closeCursor();
        return($row);
    }    
    
    public static function getAll(){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM country";
        
        $res = $res=$db->query($query);
        $res->setFetchMode(PDO::FETCH_KEY_PAIR);
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
}