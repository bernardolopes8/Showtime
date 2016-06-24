<?php

require_once(dirname(__FILE__).'/../BL/Movie_Genre.php');
require_once(dirname(__FILE__).'/../BL/Movie.php');
require_once(dirname(__FILE__).'/../BL/Genre.php');

class Movie_GenreController {
    public static function ajaxProcess() {
        if (isset($_GET['action']) && $_GET['action'] == 'addGenreToMovie') {
            $status = "";
            
            $mg = new Movie_Genre();
            $movie = new Movie();
            $genre = new Genre();
            $movie->title = $_GET['movie-title'];
            if (!$movie->getByTitle()) {
                $status = "Movie not found";
            }
            $genre->name = $_GET['genre-name'];
            if(!$genre->getByName()) {
                $status = "Genre not found";
            }
            $mg->movie = $movie->id;
            $mg->genre = $genre->id;
            if($mg->create()) {
                $status = "Genre added";
            }
            else {
                $status = "Error adding genre. Check if the movie already has the specified genre";
            }
            
            echo $status;
        }
        
        if (isset($_GET['action']) && $_GET['action'] == 'removeGenreFromMovie') {
            $status = "";
            
            $mg = new Movie_Genre();
            $movie = new Movie();
            $genre = new Genre();
            $movie->title = $_GET['movie-title'];
            if (!$movie->getByTitle()) {
                $status = "Movie not found";
            }
            $genre->name = $_GET['genre-name'];
            if(!$genre->getByName()) {
                $status = "Genre not found";
            }
            $mg->movie = $movie->id;
            $mg->genre = $genre->id;
            if($mg->delete()) {
                $status = "Genre removed";
            }
            else {
                $status = "Error removing genre";
            }
            
            echo $status;
        }
    }
}

