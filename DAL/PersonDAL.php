    <?php

require_once(dirname(__FILE__).'/../DataAbstraction/ShowtimeDB.php');

class PersonDAL {
    public static function create($person){
        $db=ShowtimeDB::getInstance();
        $query="INSERT INTO person(first_name, last_name, biography, birthdate, country_id_country) "
                . "VALUES(:first_name, :last_name, :biography, :birthdate, :country)";
        
        $res=$db->query($query, array(':first_name'=>$person->first_name, ':last_name'=>$person->last_name, ':biography'=>$person->biography, 
            ':birthdate'=>$person->birthdate, ':country'=>$person->country));
        if($res){
            $person->id=$db->lastInsertId();
        }
        return($res);
    }    
    
    public static function update($person){
        $db=ShowtimeDB::getInstance();
        $query="UPDATE person SET first_name=:first_name, last_name=:last_name, biography=:biography, birthdate=:birthdate, "
                . "country_id_country=:country WHERE id_person=:id";
        
        $res=$db->query($query, array(':first_name'=>$person->first_name, ':last_name'=>$person->last_name, ':biography'=>$person->biography, 
            ':birthdate'=>$person->birthdate, ':country'=>$person->country, ':id'=>$person->id));
        
        return($res);
    }
    
    public static function delete($person){
        
        $db=ShowtimeDB::getInstance();
        $query="DELETE FROM person WHERE id_person=:id";
        $res=$db->query($query, array(':id'=>$person->id));
        
        return($res);
    }
    
    public static function getById($person){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM person WHERE id_person=:id";
        $res=$db->query($query, array(':id' => $person->id));
        $res->setFetchMode(PDO::FETCH_CLASS, "Person");
        
        $row=$res->fetch();
        if($row){
            $person->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getByNameAndBirthdate($person){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM person WHERE first_name=:first AND last_name=:last AND birthdate=:birthdate";
        $res=$db->query($query, array(':first' => $person->first_name, ':last' => $person->last_name, ':birthdate' => $person->birthdate));
        $res->setFetchMode(PDO::FETCH_CLASS, "Person");
        
        $row=$res->fetch();
        if($row){
            $person->copy($row);
        }
        $res->closeCursor();
        return($row);
    }
    
    public static function getAll(){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM person";
        
        $res = $res=$db->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, "Person");
        
        return($res);
    }    
    
    public static function searchByName($person){
        $db = ShowtimeDB::getInstance();
        $query = "SELECT * FROM person WHERE first_name LIKE concat('%', :name, '%') OR last_name LIKE concat('%', :name, '%')";
        $res=$db->query($query, array(':name' => $person->first_name));
        $res->setFetchMode(PDO::FETCH_CLASS, "Person");
        
        $row=$res->fetchAll();
        $res->closeCursor();
        return($row);
    }
}
