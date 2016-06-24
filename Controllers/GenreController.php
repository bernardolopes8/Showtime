<?php

require_once(dirname(__FILE__).'/../BL/Genre.php');

class GenreController {
    public static function process($msg) {
        if (isset($_POST['create-genre'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-genre'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-genre'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }
    
    public static function processCreation($msg) {
        $name = $_POST['genre-name'];
        
        $error = false;
        
        if ($name == null) {
            $msg['error'][] = "Genre name is required";
            $error = true;
        }
        
        $genre = new Genre();
        $genre->name = $name;
        
        if ($genre->getByName()) {
            $msg['error'][] = "Genre already exists";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($genre->create()) {
            $msg['info'][] = "Genre succesfully created";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_name = $_POST['genre-update-old'];
        $new_name = $_POST['genre-update-new'];
        
        $error = false;
        
        if ($old_name == null || $new_name == null) {
            $msg['error'][] = "Both fields are required";
            $error = true;
        }
        
        $genre = new Genre();
        $genre->name = $old_name;
        
        if ($genre->getByName()) {
            $genre->name = $new_name;
        }
        else {
            $msg['error'][] = "Genre doesn't exist";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        if ($genre->update()) {
            $msg['info'][] = "Genre succesfully updated";
        }
        return $msg;
    }
    
    public static function processDelete($msg) {
        $name = $_POST['genre-delete'];
        
        if ($name == null) {
            $msg['error'][] = "Genre name is required";
        }
        
        $genre = new Genre();
        $genre->name = $name;
        
        if ($genre->getByName()) {
            if ($genre->delete()) {
                $msg['info'][] = "Genre succesfully deleted";
            }
        }
        else {
            $msg['error'][] = "Genre doesn't exist";
        }
        
        return $msg;
    }
    
    public static function getName($id) {
        if ($id == null) {
            return null;
        }
        $genre = new Genre();
        $genre->id = $id;
        $genre->getById();
        return $genre->name;
    }
}

