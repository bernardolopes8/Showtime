<?php

require_once(dirname(__FILE__).'/../BL/MPR.php');
require_once(dirname(__FILE__).'/../BL/Movie.php');
require_once(dirname(__FILE__).'/../BL/Person.php');
require_once(dirname(__FILE__).'/../BL/Role.php');

class MPRController {
    public static function ajaxProcess() {
        if (isset($_GET['action']) && $_GET['action'] == 'addPersonToMovie') {
            $status = "";
            
            $mpr = new MPR();
            $movie = new Movie();
            $person = new Person();
            $role = new Role();
            $movie->title = $_GET['movie-title'];
            if (!$movie->getByTitle()) {
                $status = "Movie not found";
            }
            $role->name = $_GET['role'];
            if(!$role->getByName()) {
                $status = "Role not found";
            }
            $person->first_name = $_GET['first-name'];
            $person->last_name = $_GET['last-name'];
            $person->birthdate = $_GET['birthdate'];
            if(!$person->getByNameAndBirthdate()) {
                $status = "Person not found";
            }
            
            if ($status != "") {return;}
            
            $mpr->movie = $movie->id;
            $mpr->role = $role->id;
            $mpr->person = $person->id;
            if($mpr->create()) {
                $status = "Person and role added";
            }
            else {
                $status = "Error adding person/role. Check if the movie already has the specified person and role";
            }
            
            echo $status;
        }
        
        if (isset($_GET['action']) && $_GET['action'] == 'removePersonFromMovie') {
            $status = "";
            
            $mpr = new MPR();
            $movie = new Movie();
            $person = new Person();
            $role = new Role();
            $movie->title = $_GET['movie-title'];
            if (!$movie->getByTitle()) {
                $status = "Movie not found";
            }
            $role->name = $_GET['role'];
            if(!$role->getByName()) {
                $status = "Role not found";
            }
            $person->first_name = $_GET['first-name'];
            $person->last_name = $_GET['last-name'];
            $person->birthdate = $_GET['birthdate'];
            if(!$person->getByNameAndBirthdate()) {
                $status = "Person not found";
            }
            
            if ($status != "") {return;}
            
            $mpr->movie = $movie->id;
            $mpr->role = $role->id;
            $mpr->person = $person->id;
            if($mpr->delete()) {
                $status = "Person and role removed";
            }
            else {
                $status = "Error removing person/role";
            }
            
            echo $status;
        }
    }
}

