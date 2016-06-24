<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class RoleDAL {
    
    public static function create($role){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO role(name) VALUES(:name)";
        
        $res=$db->query($query, array(':name'=>$role->name));
        if($res){
            $role->id=$db->lastInsertId();
        }
        return($res);
    }
    
    public static function update($role){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE role SET name=:name WHERE id_role=:id_role";
        
        $res=$db->query($query, array(':name'=>$role->name, ':id_role'=>$role->id));
        
        return($res);
    }
    
    public static function delete($role){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM role WHERE id_role=:id";
        $res=$db->query($query, array(':id'=>$role->id));
        
        return($res);
    }   
    
    public static function getById($role){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM role WHERE id_role=:id";
        $res=$db->query($query, array(':id' => $role->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Role");
        
        $row=$res->fetch();
        if($row){
            $role->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByName($role){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM role WHERE name=:name";
        $res=$db->query($query, array(':name' => $role->name));
        $res->setFetchMode(PDO::FETCH_CLASS, "Role");
        
        $row=$res->fetch();
        if($row){
            $role->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
}
