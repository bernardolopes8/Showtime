<?php

require_once(dirname(__FILE__).'/../BL/Person.php');

class PersonController {
    public static function process($msg) {
        if (isset($_POST['create-person'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-person'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-person'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }

    public static function processCreation($msg) {
        $first_name = $_POST['person-first-name'];
        $last_name = $_POST['person-last-name'];
        $country = $_POST['person-country'];
        $birthdate = $_POST['person-birthdate'];
        $biography = $_POST['person-biography'];
        
        if ($first_name == null || $last_name == null || $birthdate == null)
        {
             $msg['error'][] = "Name and birthdate are required";
             return $msg;
        }
        
        $person = new Person();
        $person->first_name = $first_name;
        $person->last_name = $last_name;
        $person->birthdate = $birthdate;
        $person->biography = $biography;
                
        if ($country == 'disabled') {
            $country = null;
        }
        
        $person->country = $country;
        
        if ($person->create()) {
            $msg['info'][] = "Person succesfully created";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_first = $_POST['first-name-update-old'];
        $old_last = $_POST['last-name-update-old'];
        $old_birthdate = $_POST['birthdate-update-old'];
        
        $new_first = $_POST['first-name-update-new'];
        $new_last = $_POST['last-name-update-new'];
        $new_birthdate = $_POST['birthdate-update-new'];
        $new_biography = $_POST['biography-update-new'];
        $new_country = $_POST['person-country-update'];
        
        if ($old_first == null || $old_last == null || $old_birthdate == null || $new_first == null || $new_last == null || $new_birthdate == null)
        {
             $msg['error'][] = "Name and birthdate are required";
             return $msg;
        }
        
        $person = new Person();
        $person->first_name = $old_first;
        $person->last_name = $old_last;
        $person->birthdate = $old_birthdate;
        
        if ($person->getByNameAndBirthdate()){
            $person->first_name = $old_first;
            $person->last_name = $old_last;
            $person->birthdate = $old_birthdate;
        }
        else {
            $msg['error'][] = "Person doesn't exist";
            return $msg;
        }
        
        $person->first_name = $new_first;
        $person->last_name = $new_last;
        $person->birthdate = $new_birthdate;
        $person->biography = $new_biography;
        if ($new_country == 'disabled') {
            $new_country = null;
        }
        $person->country = $new_country;
        
        if ($person->update()) {
            $msg['info'][] = "Person succesfully updated";
        }
        else {
            $msg['error'][] = "Person didn't update";
        }
        
        $upload_path = "img/people/" . $person->id . ".jpg";
        if (!empty($_FILES['person-img']['name'])) {$msg = Controller::processImgUpload($msg, 'person-img', $upload_path);}
        
        return $msg;
    }
    
    public static function processDelete($msg) {
        $first_name = $_POST['person-first-delete'];
        $last_name = $_POST['person-last-delete'];
        $birthdate = $_POST['person-birthdate-delete'];
        
        if ($first_name == null || $last_name == null || $birthdate == null)
        {
             $msg['error'][] = "Name and birthdate are required";
             return $msg;
        }
        
        $person = new Person();
        $person->first_name = $first_name;
        $person->last_name = $last_name;
        $person->birthdate = $birthdate;
        
        if ($person->getByNameAndBirthdate()){
            if ($person->delete()) {
                $msg['info'][] = "Person succesfully deleted";
            }
            else {
                $msg['error'][] = "Person doesn't exist";
            }
        }
        
        return $msg;
    }
    
    public static function getName($id) {
        if ($id == null) {
            return null;
        }
        $person = new Person();
        $person->id = $id;
        $person->getById();
        return $person->first_name . " " . $person->last_name;
    }
}