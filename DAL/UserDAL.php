<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class UserDAL {
    public static function create($user){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO user(first_name, last_name, username, email, password, birthdate, type, country_id_country) "
                . "VALUES(:first_name, :last_name, :username, :email, :password, :birthdate, :type, :country)";
        
        $res=$db->query($query, array(':first_name'=>$user->first_name, ':last_name'=>$user->last_name, ':username'=>$user->username, 
            ':email'=>$user->email, ':password'=>$user->password, ':birthdate'=>$user->birthdate, ':type'=>$user->type, ':country'=>$user->country));
        if($res){
            $user->id=$db->lastInsertId();
        }
        return($res);
    }
    
    public static function update($user){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE user SET first_name=:first_name, last_name=:last_name, username=:username, email=:email, "
                . "password=:password, birthdate=:birthdate, type=:type, country_id_country=:country WHERE id_user=:id";
        
        $res=$db->query($query, array(':first_name'=>$user->first_name, ':last_name'=>$user->last_name, ':username'=>$user->username, 
            ':email'=>$user->email, ':password'=>$user->password, ':birthdate'=>$user->birthdate, ':type'=>$user->type, ':country'=>$user->country, ':id'=>$user->id));
        
        return($res);
    }
    
    public static function delete($user){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM user WHERE id_user=:id";
        $res=$db->query($query, array(':id'=>$user->id));
        
        return($res);
    } 
    
    public static function getById($user){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM user WHERE id_user=:id";
        $res=$db->query($query, array(':id' => $user->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "User");
        
        $row=$res->fetch();
        if($row){
            $user->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByUsername($user){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM user WHERE username=:username";
        $res=$db->query($query, array(':username' => $user->username));
        $res->setFetchMode(PDO::FETCH_CLASS, "User");
        
        $row=$res->fetch();
        if($row){
            $user->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByEmail($user){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM user WHERE email=:email";
        $res=$db->query($query, array(':email' => $user->email));
        $res->setFetchMode(PDO::FETCH_CLASS, "User");
        
        $row=$res->fetch();
        if($row){
            $user->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByEmailAndPassword($user){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM user WHERE email=:email AND password=:password";
        $res=$db->query($query, array(':email' => $user->email, ':password' => $user->password));
        $res->setFetchMode(PDO::FETCH_CLASS, "User");
        
        $row=$res->fetch();
        if($row){
            $user->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getAdmins() {
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM user WHERE type=0";
        $res=$db->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, "User");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
}
