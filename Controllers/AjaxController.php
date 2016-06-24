<?php

require_once(dirname(__FILE__).'/WatchlistController.php');
require_once(dirname(__FILE__).'/Movie_GenreController.php');
require_once(dirname(__FILE__).'/MPRController.php');

if (isset($_GET['action'])) {
    WatchlistController::ajaxProcess();
    Movie_GenreController::ajaxProcess();
    MPRController::ajaxProcess();
}

