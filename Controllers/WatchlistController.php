<?php

require_once(dirname(__FILE__).'/../BL/Watchlist.php');

class WatchlistController {
    public static function ajaxProcess() {
        if (isset($_GET['action']) && $_GET['action'] == 'watchlist-add') {
            $watchlist = new Watchlist();
            $watchlist->user = $_GET['watchlist-user'];
            $watchlist->movie = $_GET['watchlist-movie'];
            $watchlist->create();
        }
        
        if (isset($_GET['action']) && $_GET['action'] == 'watchlist-remove') {
            $watchlist = new Watchlist();
            $watchlist->user = $_GET['watchlist-user'];
            $watchlist->movie = $_GET['watchlist-movie'];
            $watchlist->delete();
        }
    }
}

