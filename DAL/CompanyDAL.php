<?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class CompanyDAL {
    public static function create($company){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO company(name) VALUES(:name)";
        
        $res=$db->query($query, array(':name'=>$company->name));
        if($res){
            $company->id=$db->lastInsertId();
        }
        return($res);
    }
    
    public static function update($company){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE company SET name=:name WHERE id_company=:id_company";
        
        $res=$db->query($query, array(':name'=>$company->name, ':id_company'=>$company->id));
        
        return($res);
    }
    
    public static function delete($company){
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM company WHERE id_company=:id_company";
        $res=$db->query($query, array(':id_company'=>$company->id));
        
        return($res); 
    }
    
    public static function getById($company){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM company WHERE id_company=:id_company";
        $res=$db->query($query, array(':id_company' => $company->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Company");
        
        $row=$res->fetch();
        if($row){
            $company->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByName($company){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM company WHERE name=:name";
        $res=$db->query($query, array(':name' => $company->name));
        $res->setFetchMode(PDO::FETCH_CLASS, "Company");
        
        $row=$res->fetch();
        if($row){
            $company->copy($row);
        }
        $res->closeCursor();
        return($row);
    }    
    
    public static function getAll(){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM company";
        
        $res = $res=$db->query($query);
        $res->setFetchMode(PDO::FETCH_KEY_PAIR);
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
}

