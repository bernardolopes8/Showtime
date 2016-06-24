<?php

require_once(dirname(__FILE__).'/../BL/Company.php');

class CompanyController {
    public static function process($msg) {
        if (isset($_POST['create-company'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-company'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-company'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }
    
    public static function processCreation($msg) {
        $name = $_POST['company-name'];
        
        $error = false;
        
        if ($name == null) {
            $msg['error'][] = "Company name is required";
            $error = true;
        }
        
        $company = new Company();
        $company->name = $name;
        
        if ($company->getByName()) {
            $msg['error'][] = "Company already exists";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($company->create()) {
            $msg['info'][] = "Company succesfully created";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_name = $_POST['company-update-old'];
        $new_name = $_POST['company-update-new'];
        
        $error = false;
        
        if ($old_name == null || $new_name == null) {
            $msg['error'][] = "Both fields are required";
            $error = true;
        }
        
        $company = new Company();
        $company->name = $old_name;
        
        if ($company->getByName()) {
            $company->name = $new_name;
        }
        else {
            $msg['error'][] = "Company doesn't exist";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($company->update()) {
            $msg['info'][] = "Company succesfully updated";
        }
        return $msg;
    }
    
    public static function processDelete($msg) {
        $name = $_POST['company-delete'];
        
        if ($name == null) {
            $msg['error'][] = "Company name is required";
        }
        
        $company = new Company();
        $company->name = $name;
        
        if ($company->getByName()) {
            if ($company->delete()) {
                $msg['info'][] = "Company succesfully deleted";
            }
        }
        else {
            $msg['error'][] = "Company doesn't exist";
        }
        
        return $msg;
    }
    
    public static function getName($id) {
        if ($id == null) {
            return null;
        }
        $company = new Company();
        $company->id = $id;
        $company->getById();
        return $company->name;
    }
}

