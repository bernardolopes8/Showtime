<?php

require_once(dirname(__FILE__).'/../BL/User.php');
require_once(dirname(__FILE__).'/../BL/Watchlist.php');

class UserController {
    public static function process($msg) {
        if (isset($_POST['register'])) {
            $msg = self::processRegistration($msg); 
        }
        else if (isset($_POST['login'])) {
            $msg = self::processLogin($msg);
        }
        else if (isset($_POST['logout'])) {
            $msg = self::processLogout($msg);
        }
        else if (isset($_POST['img-upload'])) {
            $target = "img/user-avatars/" . self::getLoggedInUser()->id . ".jpg";
            $file_id = 'userAvatar';
            $msg = Controller::processImgUpload($msg, $file_id, $target);
        }
        else if (isset($_POST['save-password'])) {
            $msg = self::processPasswordChange($msg);
        }
        else if (isset($_POST['save-email'])) {
            $msg = self::processEmailChange($msg);
        }
        else if (isset($_POST['save-personalinfo'])) {
            $msg = self::processInfoChange($msg);
        }
        else if (isset($_POST['change-user-type'])) {
            $msg = self::processTypeChange($msg);
        }
        return $msg;
    }
    
    public static function processRegistration($msg) {
        $username = $_POST['username'];
        $input_password = $_POST['password'];
        $password_validation = $_POST['password_validation'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $country = $_POST['country'];
        $birthdate = $_POST['birthdate'];
        
        $_SESSION['register-username'] = $username;
        $_SESSION['register-email'] = $email;
        $_SESSION['register-firstname'] = $firstname;
        $_SESSION['register-lastname'] = $lastname;
        $_SESSION['register-birthdate'] = $birthdate;
        
        $error = false;
        if ($username == null || $email == null || $input_password == null || $password_validation == null)
        {
             $msg['error'][] = "Fields marked with * are required";
             $error = true;
        }
        if ($input_password != $password_validation) {
            $msg['error'][] = "Passwords must match";
            $error = true;
        }
        $user = new User();
        $user->email = $email;
        $user->username = $username;
        if ($user->getByEmail()) {
            $msg['error'][] = "Email already in use";
            $error = true;
        }
        if ($user->getByUsername()) {
            $msg['error'][] = "Username already in use";
            $error = true;
        }
        if ($error == true) {
            return $msg;
        }
        
        if ($country == 'disabled') {
            $country = null;
        }
        $hash_password = password_hash($input_password, PASSWORD_DEFAULT);
        $user->first_name = $firstname;
        $user->last_name = $lastname;
        $user->country = $country;
        $user->password = $hash_password;
        $user->birthdate = $birthdate;
        $user->type = 1;
        if ($user->create()) {
            $msg['info'][] = "Succesfully registered";
        }
        return $msg;
    }
    
    public static function processLogin($msg) {
        $email = $_POST['email'];
        $input_password = $_POST['password'];
        $user = new User();
        $user->email = $email;
        if($user->getByEmail()) {
            $hash_password = $user->password;
            $_SESSION['login-email'] = $email;
            if (password_verify($input_password, $hash_password)) {
                $msg['info'][] = "User logged in";
                $userid = $user->id;
                self::setSessionUserId($userid);
                header("Location:index.php");
                return $msg;
            }
        }
        
        $msg['error'][] = "Invalid email or password";
        return $msg;
    }
    
    public static function processLogout($msg) {
        $_SESSION = array();
        
        if(ini_get("session-user_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],
                    $params["httponly"]);
        }
        
        session_destroy();
        $msg['info'][] = "User logged out";
        return $msg;
    }
    
    public static function processPasswordChange($msg) {
        $current = $_POST['currentpass'];
        $new = $_POST['newpass'];
        $confirmation = $_POST['confirmpass'];
        
        $error = false;
        if ($current == null || $new == null || $confirmation == null)
        {
             $msg['error'][] = "Please fill all the required fields";
             $error = true;
        }
        
        if ($new != $confirmation) {
            $msg['error'][] = "Passwords must match";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        $user = self::getLoggedInUser();
        
        if (password_verify($current, $user->password)) {
            $user->password = password_hash($new, PASSWORD_DEFAULT);
            if ($user->update()) {
                $msg['info'][] = "Password succesfully changed";
            }
        }
        else {
            $msg['error'][] = "Invalid current password";
        }
        
        return $msg;
    }
    
    public static function processEmailChange($msg) {
        $current = $_POST['currentemail'];
        $new = $_POST['newemail'];
        $confirmation = $_POST['confirmemail'];
        
        $error = false;
        if ($current == null || $new == null || $confirmation == null)
        {
             $msg['error'][] = "Please fill all the required fields";
             $error = true;
        }
        
        if ($new != $confirmation) {
            $msg['error'][] = "Emails must match";
            $error = true;
        }
        
        if ($error == true) {
            return $msg;
        }
        
        $user = self::getLoggedInUser();
        
        if ($current == $user->email) {
            $user->email = $new;
            if ($user->update()) {
                $msg['info'][] = "Email succesfully changed";
            }
        }
        else {
            $msg['error'][] = "Invalid current email";
        }
        
        return $msg;  
    }
    
    public static function processInfoChange($msg) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birthdate = $_POST['birthdate'];
        $country = $_POST['country'];
        
        $user = self::getLoggedInUser();
        
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->birthdate = $birthdate;
        if ($country != 'disabled') {
            $user->country = $country;
        }
        
        if ($user->update()) {
            $msg['info'][] = "Info succesfully changed";
        }
        else {
            $msg['error'][] = "There was an error updating your info";
        }
        
        return $msg;
    }
    
    public static function processTypeChange($msg) {
        $email = $_POST['user-email'];
        $type = $_POST['user-type'];
        
        if($email == "default@admin.com") {
            $msg['error'][] = "Default admin can't be changed";
            return $msg;
        }
        
        $user = new User();
        $user->email = $email;
        
        if ($user->getByEmail()) {
            $user->type = $type;
            if ($user->update()) {
                $msg['info'][] = "Succesfully changed";
            }
            else {
                $msg['error'][] = "Error changing type";
            }
        }
        else {
            $msg['error'][] = "User doesn't exist";
        }
        
        return $msg;
    }
    
    public static function setSessionUserId($userid) {
        $_SESSION['userid'] = $userid;
    }
    
    public static function getSessionUserId(){
        return isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    }
    
    public static function getLoggedInUser(){
        $id = self::getSessionUserId();
        if ($id == null) {
            return null;
        }
        $user = new User();
        $user->id = $id;
        $user->getById();
        return $user;
    }
    
    public static function isAdminLoggedIn(){
        $user = self::getLoggedInUser();
        return ($user && $user->isAdmin());
    }
    
    public static function hasMovieWatchlist($id_movie) {
        $user = self::getLoggedInUser();
        $watchlist = new Watchlist();
        $watchlist->user = $user->id;
        $watchlist->movie = $id_movie;
        if ($watchlist->getByUserAndMovie()) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public static function createDefaultAdmin() {
        $admin = new User();
        $admin->username = "admin";
        $admin->email = "default@admin.com";
        $admin->password = password_hash("admin", PASSWORD_DEFAULT);
        $admin->type = 0;
        $admin->create();
    }
}