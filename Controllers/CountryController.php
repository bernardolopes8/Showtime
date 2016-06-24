<?php

require_once(dirname(__FILE__).'/../BL/Country.php');

class CountryController {
    public static function process($msg) {
        if (isset($_POST['create-country'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-country'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-country'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }
    
    public static function processCreation($msg) {
        $name = $_POST['country-name'];
        
        $error = false;
        
        if ($name == null) {
            $msg['error'][] = "Country name is required";
            $error = true;
        }
        
        $country = new Country();
        $country->name = $name;
        
        if ($country->getByName()) {
            $msg['error'][] = "Country already exists";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($country->create()) {
            $msg['info'][] = "Country succesfully created";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_name = $_POST['country-update-old'];
        $new_name = $_POST['country-update-new'];
        
        $error = false;
        
        if ($old_name == null || $new_name == null) {
            $msg['error'][] = "Both fields are required";
            $error = true;
        }
        
        $country = new Country();
        $country->name = $old_name;
        
        if ($country->getByName()) {
            $country->name = $new_name;
        }
        else {
            $msg['error'][] = "Country doesn't exist";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($country->update()) {
            $msg['info'][] = "Country succesfully updated";
        }
        return $msg;
    }
    
    public static function processDelete($msg) {
        $name = $_POST['country-delete'];
        
        if ($name == null) {
            $msg['error'][] = "Country name is required";
        }
        
        $country = new Country();
        $country->name = $name;
        
        if ($country->getByName()) {
            if ($country->delete()) {
                $msg['info'][] = "Country succesfully deleted";
            }
        }
        else {
            $msg['error'][] = "Country doesn't exist";
        }
        
        return $msg;
    }    
    
    public static function getCountryName($id) {
        if ($id == null) {
            return null;
        }
        $country = new Country();
        $country->id = $id;
        $country->getById();
        return $country->name;
    }
}

