<?php

require_once(dirname(__FILE__) . "/UserController.php");
require_once(dirname(__FILE__) . "/CountryController.php");
require_once(dirname(__FILE__) . "/MovieController.php");
require_once(dirname(__FILE__) . "/GenreController.php");
require_once(dirname(__FILE__) . "/CompanyController.php");
require_once(dirname(__FILE__) . "/CountryController.php");
require_once(dirname(__FILE__) . "/RoleController.php");
require_once(dirname(__FILE__) . "/PersonController.php");
require_once(dirname(__FILE__) . "/MPRController.php");
require_once(dirname(__FILE__) . "/IndexController.php");
require_once(dirname(__FILE__) . "/Movie_GenreController.php");

class Controller {

    public static function process() {
        session_start();
        $msg = array();

        $msg = UserController::process($msg);
        $msg = MovieController::process($msg);
        $msg = GenreController::process($msg);
        $msg = CompanyController::process($msg);
        $msg = CountryController::process($msg);
        $msg = RoleController::process($msg);
        $msg = PersonController::process($msg);
        $msg = IndexController::process($msg);
        
        return $msg;
    }
    
    public static function processImgUpload($msg, $file_id, $target_file) {
        $uploadOk = 1;
        $imageFileType = pathinfo(basename($_FILES[$file_id]["name"]),PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES[$file_id]["tmp_name"]);
        if($check !== false) {
              echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES[$file_id]["size"] > 10000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (Controller::convertImage($imageFileType, $_FILES[$file_id]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES[$file_id]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }  
    }
    
    public static function convertImage($ext, $originalImage, $outputImage) {
        if (preg_match('/jpg|jpeg/i',$ext)) {
            $imageTmp=imagecreatefromjpeg($originalImage);
        }
        else if (preg_match('/png/i',$ext)) {
            $imageTmp=imagecreatefrompng($originalImage);
        }
        else if (preg_match('/gif/i',$ext)) {
            $imageTmp=imagecreatefromgif($originalImage);
        }
        else if (preg_match('/bmp/i',$ext)) {
            $imageTmp=imagecreatefrombmp($originalImage);
        }
        else {
            return false;
        }

        // quality is a value from 0 (worst) to 100 (best)
        imagejpeg($imageTmp, $outputImage, 100);
        imagedestroy($imageTmp);

        return true;
    }
}

