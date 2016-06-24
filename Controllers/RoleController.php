<?php

require_once(dirname(__FILE__).'/../BL/Role.php');

class RoleController {
    public static function process($msg) {
        if (isset($_POST['create-role'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-role'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-role'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }
    
    public static function processCreation($msg) {
        $name = $_POST['role-name'];
        
        $error = false;
        
        if ($name == null) {
            $msg['error'][] = "Role name is required";
            $error = true;
        }
        
        $role = new Role();
        $role->name = $name;
        
        if ($role->getByName()) {
            $msg['error'][] = "Role already exists";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($role->create()) {
            $msg['info'][] = "Role succesfully created";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_name = $_POST['role-update-old'];
        $new_name = $_POST['role-update-new'];
        
        $error = false;
        
        if ($old_name == null || $new_name == null) {
            $msg['error'][] = "Both fields are required";
            $error = true;
        }
        
        $role = new Role();
        $role->name = $old_name;
        
        if ($role->getByName()) {
            $role->name = $new_name;
        }
        else {
            $msg['error'][] = "Role doesn't exist";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($role->update()) {
            $msg['info'][] = "Role succesfully updated";
        }
        return $msg;
    }
    
    public static function processDelete($msg) {
        $name = $_POST['role-delete'];
        
        if ($name == null) {
            $msg['error'][] = "Role name is required";
        }
        
        $role = new Role();
        $role->name = $name;
        
        if ($role->getByName()) {
            if ($role->delete()) {
                $msg['info'][] = "Role succesfully deleted";
            }
        }
        else {
            $msg['error'][] = "Role doesn't exist";
        }
        
        return $msg;
    }    
    
    public static function getName($id) {
        if ($id == null) {
            return null;
        }
        $role = new Role();
        $role->id = $id;
        $role->getById();
        return $role->name;
    }
}

