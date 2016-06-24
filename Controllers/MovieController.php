<?php

require_once(dirname(__FILE__).'/../BL/Movie.php');

class MovieController {
    public static function process($msg) {
        if (isset($_POST['create-movie'])) {
            $msg = self::processCreation($msg); 
        }
        else if (isset($_POST['update-movie'])) {
            $msg = self::processUpdate($msg);
        }
        else if (isset($_POST['delete-movie'])) {
            $msg = self::processDelete($msg);
        }
        return $msg;
    }
    
    public static function processCreation($msg) {
        $title = $_POST['movie-title'];
        $date = $_POST['movie-date'];
        $runtime = $_POST['movie-runtime'];
        $trailer = $_POST['movie-trailer'];
        $company = $_POST['movie-company'];
        $country = $_POST['movie-country'];
        $synopsys = $_POST['movie-synopsys'];
        $rating = $_POST['movie-rating'];
        
        if ($title == null) {
            $msg['error'][] = "Title is required";
            return $msg;
        }
        
        $aux = explode(':', $runtime);
        $runtime_seconds = 3600*$aux[0] + 60*$aux[1];
        
        $movie = new Movie();
        $movie->title = $title;
        $movie->release_date = $date;
        $movie->trailer = $trailer;
        $movie->runtime = $runtime_seconds;
        $movie->synopsys = $synopsys;
        $movie->rating = $rating;
        
        if ($country == 'disabled') {
            $country = null;
        }
        
        if ($company == 'disabled') {
            $company = null;
        }
        
        $movie->country = $country;
        $movie->company = $company;
        
        if ($movie->create()) {
            $msg['info'][] = "Movie succesfully created";
        }
        else {
            $msg['error'][] = "Error creating movie";
        }
        return $msg;
    }
    
    public static function processUpdate($msg) {
        $old_title = $_POST['movie-title-old'];
        $title = $_POST['movie-title-new'];
        $date = $_POST['movie-date-new'];
        $runtime = $_POST['movie-runtime-new'];
        $trailer = $_POST['movie-trailer-new'];
        $company = $_POST['movie-company-new'];
        $country = $_POST['movie-country-new'];
        $synopsys = $_POST['movie-synopsys-new'];
        $rating = $_POST['movie-rating-new'];
        
        if ($title == null || $old_title == null) {
            $msg['error'][] = "Titles are required";
            return $msg;
        }
        
        
        
        $movie = new Movie();
        $movie->title = $old_title;
        
        if(!$movie->getByTitle()) {
            $msg['error'][] = "Movie doesn't exist";
            return $msg;
        }
        
        $movie->title = $title;
        $movie->release_date = $date;
        $movie->trailer = $trailer;
        
        if ($runtime != "") {
            $aux = explode(':', $runtime);
            $runtime_seconds = 3600*$aux[0] + 60*$aux[1];
            $movie->runtime = $runtime_seconds;
        }
        
        $movie->synopsys = $synopsys;
        $movie->rating = $rating;
        
        if ($country == 'disabled') {
            $country = null;
        }
        
        if ($company == 'disabled') {
            $company = null;
        }
        
        $movie->country = $country;
        $movie->company = $company;
        
        if ($movie->update()) {
            $msg['info'][] = "Movie succesfully updated";
        }
        else {
            $msg['error'][] = "Error updating movie";
        }
        
        $upload_path = "img/movies/" . $movie->id . ".jpg";
        if (!empty($_FILES['movie-img']['name'])) {$msg = Controller::processImgUpload($msg, 'movie-img', $upload_path);}
        
        return $msg;
    }
    
    public static function processDelete($msg) {
        $title = $_POST['title-delete'];
        
        if ($title == null)
        {
             $msg['error'][] = "Title is required";
             return $msg;
        }
        
        $movie = new Movie();
        $movie->title = $title;
        
        if ($movie->getByTitle()){
            if ($movie->delete()) {
                $msg['info'][] = "Movie succesfully deleted";
            }
            else {
                $msg['error'][] = "Movie doesn't exist";
            }
        }
        
        return $msg;
    }
    
    public static function getTitle($id) {
        if ($id == null) {
            return null;
        }
        $movie = new Movie();
        $movie->id = $id;
        $movie->getById();
        return $movie->title;
    }
}

