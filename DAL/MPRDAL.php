<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class MPRDAL {
    public static function create($mpr){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO movie_person_role(movie_id_movie, person_id_person, role_id_role) VALUES(:movie, :person, :role)";
        
        $res=$db->query($query, array(':movie'=>$mpr->movie, ':person'=>$mpr->person, ':role'=>$mpr->role));
        return($res);
    }
    
    public static function update($mpr){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE movie_person_role SET role_id_role=:role WHERE movie_id_movie=:movie AND person_id_person=:person";
        
        $res=$db->query($query, array(':role'=>$mpr->role, ':movie'=>$mpr->movie, ':person'=>$mpr->person));
        
        return($res);
    }
    
    public static function delete($mpr){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM movie_person_role WHERE movie_id_movie=:movie AND person_id_person=:person AND role_id_role=:role";
        $res=$db->query($query, array(':movie'=>$mpr->movie, ':person'=>$mpr->person, ':role'=>$mpr->role));
        
        return($res); 
    }
    
    public static function getByMovie($mpr){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_person_role WHERE movie_id_movie=:movie ORDER BY role_id_role";
        $res=$db->query($query, array(':movie' => $mpr->movie));
        $res->setFetchMode(PDO::FETCH_CLASS, "MPR");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
    
    public static function getByPerson($mpr){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_person_role WHERE person_id_person=:person ORDER BY role_id_role";
        $res=$db->query($query, array(':person' => $mpr->person));
        $res->setFetchMode(PDO::FETCH_CLASS, "MPR");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
    
    public static function getByRole($mpr){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_person_role WHERE role_id_role=:role";
        $res=$db->query($query, array(':role' => $mpr->role));
        $res->setFetchMode(PDO::FETCH_CLASS, "MPR");
        
        $row=$res->fetch();
        if($row){
            $mpr->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByCombination($mpr){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM movie_person_role WHERE role_id_role=:role AND person_id_person=:person AND movie_id_movie=:movie";
        $res=$db->query($query, array(':role' => $mpr->role, ':person' => $mpr->person, ':movie' => $mpr->movie));
        $res->setFetchMode(PDO::FETCH_CLASS, "MPR");
        
        $row=$res->fetch();
        $res->closeCursor();
        return($row);
    }
}

