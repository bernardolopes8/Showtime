<!DOCTYPE html>

<?php
    require_once(dirname(__FILE__).'/Controllers/Controller.php'); 
    $msg = Controller::process();
    if (isset($_GET['m'])) {
                $id = $_GET['m'];
                $movie = new Movie();
                $movie->id = $id;
                if (!$movie->getById()) {
                    header('Location:notFound.php');
                }
            }else{
                header('Location:notFound.php');
            }
?>

<html>
 <head>
     <link href="css/movie.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title><?php echo $movie->title;?></title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php 
            if (UserController::getSessionUserId()) {?>
        <script type = "text/javascript">
            function showMessage() {
                document.getElementById("watchlist-input").value = "Remove";
            }
            
            function clearMessage() {
                document.getElementById("watchlist-input").value = "On Watchlist";
            }
            
            function addToWatchlist() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        setTimeout(function(){document.getElementById("watchlist-button").innerHTML = '<br/><input id="watchlist-input" type="button" class="button-rm" name="watchlist-remove" value="On Watchlist" onmouseover="showMessage()" onmouseout="clearMessage()" onclick="removeFromWatchlist()"/>';}, 100);
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?watchlist-movie=<?php echo $id;?>&watchlist-user=\n\
                    <?php echo UserController::getLoggedInUser()->id;?>&action=watchlist-add", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
            
            function removeFromWatchlist() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        setTimeout(function(){document.getElementById("watchlist-button").innerHTML = '<br/><input id="watchlist-input" type="button" class="button" name="watchlist-add" value="Add to Watchlist" onclick="addToWatchlist()"/>';}, 100);
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?watchlist-movie=<?php echo $id;?>&watchlist-user=\n\
                    <?php echo UserController::getLoggedInUser()->id;?>&action=watchlist-remove", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
        </script>
        <?php }?>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
        ?>
        <main>
            <div id="all">
            <div id="left">
                <h1><?php echo $movie->title ?></h1>
                <?php
                    $poster = 'img/movies/' . $movie->id . '.jpg';
                    if (!file_exists($poster)) {
                        $poster = 'img/misc/placeholder-poster.png';
                    }
                ?>
                <img class="movie-img" src="<?php echo $poster;?>"/>
                <p><span class="red">»</span> <?php if(isset($movie->rating) && $movie->rating != 0) {echo $movie->rating;?> ★ <?php } else { echo "Not rated yet";}?></p>
                <?php 
                if(isset($movie->release_date) && $movie->release_date != "") {
                    $dates = explode('-', $movie->release_date);
                    $year = $dates[0];
                    $month = $dates[1];
                    $day = $dates[2];
                }
                ?>
                <p><span class="red">»</span> <?php if(isset($year)) {echo $year;} else { echo "TBA";}?></p>
                <p><span class="red">»</span> 
                <?php 
                    $mr = new Movie_Genre();
                    $mr->movie = $movie->id;
                    $genres = $mr->getByMovie();
                    if ($genres) {
                        $genres_display = array();

                        for ($i = 0; $i < count($genres); $i++) {
                            $genres_display[$i] = GenreController::getName($genres[$i]->genre_id_genre);
                        }

                        sort($genres_display);
                        echo implode(', ', $genres_display);
                    }
                    else {
                        echo "Unknown genre";
                    }
                ?>
                </p>
                <div id="watchlist-button">
                <?php
                    if (UserController::getSessionUserId()) {
                        if (UserController::hasMovieWatchlist($movie->id)) {
                            echo '<br/><input id="watchlist-input" type="button" class="button-rm" name="watchlist-remove" value="On Watchlist" onmouseover="showMessage()" onmouseout="clearMessage()" onclick="removeFromWatchlist()"/>';
                        }
                        else {
                            echo '<br/><input id="watchlist-input" type="button" class="button" name="watchlist-add" value="Add to Watchlist" onclick="addToWatchlist()"/>';
                        }
                    }
                ?>
                </div>
            </div>
            <div id="right">
                <?php if(isset($movie->trailer) && $movie->trailer != "") {?>
                <iframe id="trailer" src="<?php echo $movie->trailer;?>" frameborder="0" allowfullscreen></iframe>
                <?php } ?>
                <h1>Details</h1>
                <p class="pr"><span class="red">Run time: </span>
                    <?php 
                        if(isset($movie->runtime) && $movie->runtime != 0) {
                            $seconds = $movie->runtime;
                            echo gmdate("H\h i\m\i\\n", $seconds);
                        } else {
                            echo "TBA";
                        }
                    ?>
                </p>
                <?php 
                    $mpr = new MPR();
                    $mpr->movie = $movie->id;
                    $cast = $mpr->getByMovie();
                ?>
                <?php
                        $actor = new Role();
                        $actor->name = 'Actor';
                        $actor->getByName();
                        
                        $stars = array();
                        
                        for ($i = 0; $i < count($cast); $i++) {
                            if ($cast[$i]->role_id_role == $actor->id) {
                                $stars[$i] = PersonController::getName($cast[$i]->person_id_person);
                                if ($i == 2) {
                                    break;
                                }
                            }
                        }
                        if ($stars) {
                            echo '<p class="pr"><span class="red">Main Stars: </span>';
                            ksort($stars);
                            echo implode(', ', $stars);
                            echo '</p>';
                        }
                    ?>
                <p class="pr"><span class="red">Synopsys: </span><?php if(isset($movie->synopsys)) {echo $movie->synopsys;} else {echo "No synopsys yet";}?></p>
                <p class="pr"><span class="red">Cast: </span>
                    <?php
                        if ($cast) {
                            echo '</p><table id="table">';
                            foreach ($cast as $m=>$pr) {
                                echo '<tr><td><a class="person-link" href="person.php?p=' . $pr->person_id_person . '">' .
                                        PersonController::getName($pr->person_id_person) . "</a></td><td>" . 
                                        RoleController::getName($pr->role_id_role) . "</td></tr>";
                            }
                            echo '</table>';
                        }
                        else {
                            echo "No cast yet</p>";
                        }
                    ?>
                <p class="pr"><span class="red">Release Date: </span><?php if(isset($movie->release_date) && $movie->release_date != "") {echo $day . '/' . $month . '/' . $year;} else {echo "TBA";}?></p>
                <?php 
                    if(isset($movie->country)) {
                        $country = CountryController::getCountryName($movie->country);
                    }
                    
                    if(isset($movie->company)) {
                        $company = CompanyController::getName($movie->company);
                    }
                ?>
                <p class="pr"><span class="red">Company: </span><?php if(isset($company)) {echo $company;} else {echo "Unknown";}?></p>
                <p class="pr"><span class="red">Country: </span><?php if(isset($country)) {echo $country;} else {echo "Unknown";}?></p>
            </div>
            </div>
        </main>
        <?php
            include('page-elements/footer.php');
        ?>
    </body>
</html>