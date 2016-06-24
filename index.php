<!DOCTYPE html>

<?php
    require_once(dirname(__FILE__) . '/Controllers/Controller.php');
    $msg = Controller::process();

    // Creates an admin if none exist
    $defaultAdmin = new User();
    $admins = $defaultAdmin->getAdmins();
    if(!$admins) {
        UserController::createDefaultAdmin();
        // Default admin:
        // Email: default@admin.com
        // Password: admin
    }
    $content = IndexController::getData();
    
    $featuredMovies = [];
    foreach ($content['featured'] as $key => $movie_title) {
        $featuredMovies[$key] = new Movie();
        $featuredMovies[$key]->title = $movie_title;
        $featuredMovies[$key]->getByTitle();
    }
    
    function getGenres($movie) {
        $mr = new Movie_Genre();
        $mr->movie = $movie->id;
        $genres = $mr->getByMovie();
        if ($genres) {
            $genres_display = array();

            for ($i = 0; $i < count($genres); $i++) {
                $genres_display[$i] = GenreController::getName($genres[$i]->genre_id_genre);
            }

            sort($genres_display);
            return implode(', ', $genres_display);
        }
        else {
             return "Unknown genre";
        }
    }
    
    function dateConversion($date) {
        if ($date != null) {
            $exploded = explode('-', $date);
            $conversion = array($exploded[2], $exploded[1], $exploded[0]);
            $newDate = implode('/', $conversion);
            return $newDate;
        }
        else {
            return "TBA";
        }
    }
    
    function getStars($movieIn) {
        $mpr = new MPR();
        $mpr->movie = $movieIn->id;
        $cast = $mpr->getByMovie();
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
            ksort($stars);
            echo implode(', ', $stars);
        }
        else {
            echo "No known cast";
        }
    }
?>

<html>
    <head>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type = "text/javascript">
            var old = 3;
            var navElement = document.getElementsByClassName("mnav");
            var navAnchor = document.getElementsByClassName("mnav-anchor");
            
            var jsonrequest = new XMLHttpRequest();
            jsonrequest.open("GET", "index.json", false);
            jsonrequest.send(null)
            var content = JSON.parse(jsonrequest.responseText);
            
            function drawInitialState() {
                document.getElementById("m1").innerHTML = t[0];
                document.getElementById("m2").innerHTML = t[1];
                document.getElementById("m3").innerHTML = t[2];
                document.getElementById("m4").innerHTML = t[3];
                
                navAnchor[0].href = link[0];
                navAnchor[1].href = link[1];
                navAnchor[2].href = link[2];
                navAnchor[3].href = link[3];
            }
            
            function displayNextImage() {
                setInactive(old);
                
                x = (x === images.length - 1) ? 0 : x + 1;
                
                old = x;
                
                setActive(x);
                
                document.getElementById("img").src = images[x];
                document.getElementById("t").innerHTML = t[x];
                document.getElementById("d").innerHTML = d[x];
                document.getElementById("y").innerHTML = y[x];
                document.getElementById("s").innerHTML = s[x];
                
                document.getElementById("featuredBodyLink").setAttribute("href", link[x]);
            }
            
            function setActive(x) {
                navElement[x].classList.add("active"); 
                navElement[x].classList.remove("inactive");
            }
            
            function setInactive(old) {
                navElement[old].classList.remove("active");
                navElement[old].classList.add("inactive");
            }
            
            function changeMovie(x) {
                setActive(x);
                document.getElementById("img").src = images[x];
                document.getElementById("t").innerHTML = t[x];
                document.getElementById("d").innerHTML = d[x];
                document.getElementById("y").innerHTML = y[x];
                document.getElementById("s").innerHTML = s[x];
                document.getElementById("featuredBodyLink").setAttribute("href", link[x]);
            }
            
            function startTimer() {
                setInterval(displayNextImage, 3000);
            }

            var images = [], x = -1;
            images[0] = "img/featured/1.jpg";
            images[1] = "img/featured/2.jpg";
            images[2] = "img/featured/3.jpg";
            images[3] = "img/featured/4.jpg";


            var t = [], x = -1;
            t = content['featured'];

            var d = [], x = -1;
            d = ["<?php echo getGenres($featuredMovies[0]);?>", "<?php echo getGenres($featuredMovies[1]);?>", "<?php echo getGenres($featuredMovies[2]);?>", 
            "<?php echo getGenres($featuredMovies[3]);?>"];

            var y = [], x = -1;
            y = ["<?php echo dateConversion($featuredMovies[0]->release_date);?>", "<?php echo dateConversion($featuredMovies[1]->release_date);?>",
                        "<?php echo dateConversion($featuredMovies[2]->release_date);?>", "<?php echo dateConversion($featuredMovies[3]->release_date);?>"];

            var s = [], x = -1;
            s = ["<?php getStars($featuredMovies[0]);?>", "<?php getStars($featuredMovies[1]);?>", "<?php getStars($featuredMovies[2]);?>", 
                    "<?php getStars($featuredMovies[3]);?>"];
            
            var link = [], x = -1;
            link[0] = "movie.php?m=" + "<?php echo $featuredMovies[0]->id;?>";
            link[1] = "movie.php?m=" + "<?php echo $featuredMovies[1]->id;?>";
            link[2] = "movie.php?m=" + "<?php echo $featuredMovies[2]->id;?>";
            link[3] = "movie.php?m=" + "<?php echo $featuredMovies[3]->id;?>";
        </script>
    </head>
    <body onload = "drawInitialState(); displayNextImage(); startTimer();">
        <?php
        include('page-elements/header.php');
        ?>
        <main>
            <div id="page">
                <h1 id="featured-title">Featured</h1>
                <div id="featured-box">
                    <ul id="featured-tabs">
                        <a class="mnav-anchor"><li onmouseover="changeMovie(0)" onmouseout="setInactive(0)" class="mnav inactive" id="m1"></li></a>
                        <a class="mnav-anchor"><li onmouseover="changeMovie(1)" onmouseout="setInactive(1)" class="mnav inactive" id="m2"></li></a>
                        <a class="mnav-anchor"><li onmouseover="changeMovie(2)" onmouseout="setInactive(2)" class="mnav inactive" id="m3"></li></a>
                        <a class="mnav-anchor"><li onmouseover="changeMovie(3)" onmouseout="setInactive(3)" class="mnav inactive" id="m4"></li></a>
                    </ul>
                    <a id="featuredBodyLink" href="movie.php"><img id="img" src="" alt="Featured Movie">
                        <div id="featured-details">
                            <h2 id="t"></h2>
                            <ul id="details-list">
                                <li id="d"></li>
                                <li id="y"></li>
                                <li id="s"></li>
                            </ul>
                        </div>
                    </a>
                </div>
                <section class="list" id="top-movies">
                    <h3>Top Movies of the Week</h3>
                    <?php
                        $topMovie1 = new Movie();
                        $topMovie1->title = $content['top'][0];
                        $topMovie1->getByTitle();
                        
                        $topMovie2 = new Movie();
                        $topMovie2->title = $content['top'][1];
                        $topMovie2->getByTitle();
                       
                        $topMovie3 = new Movie();
                        $topMovie3->title = $content['top'][2];
                        $topMovie3->getByTitle();
                    ?>
                    <ul id="top-movies-list">
                        <a href="movie.php?m=<?php echo $topMovie1->id?>"><li>
                                <img class="list-img" src=<?php echo "\"img/movies/" . $topMovie1->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $topMovie1->title ?></h4>
                                    <br/><?php echo getGenres($topMovie1)?>
                                    <br/>
                                    <br/><?php echo dateConversion($topMovie1->release_date);?>
                                </div>
                            </li></a>
                        <br>
                        <a href="movie.php?m=<?php echo $topMovie2->id?>"><li class="clear">
                                <img class="list-img" src=<?php echo "\"img/movies/" . $topMovie2->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $topMovie2->title ?></h4>
                                    <br/><?php echo getGenres($topMovie2)?>
                                    <br/>
                                    <br/><?php echo dateConversion($topMovie2->release_date);?>
                                </div>
                            </li></a>
                        <a href="movie.php?m=<?php echo $topMovie3->id?>"><li class="clear">
                                <img class="list-img" src=<?php echo "\"img/movies/" . $topMovie3->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $topMovie3->title ?></h4>
                                    <br/><?php echo getGenres($topMovie3)?>
                                    <br/>
                                    <br/><?php echo dateConversion($topMovie3->release_date);?>
                                </div>
                            </li></a>
                    </ul>
                </section>
                <section class="list" id="coming-soon">
                    <h3>Coming Soon</h3>
                    <?php
                        $soonMovie1 = new Movie();
                        $soonMovie1->title = $content['soon'][0];
                        $soonMovie1->getByTitle();
                        
                        $soonMovie2 = new Movie();
                        $soonMovie2->title = $content['soon'][1];
                        $soonMovie2->getByTitle();
                       
                        $soonMovie3 = new Movie();
                        $soonMovie3->title = $content['soon'][2];
                        $soonMovie3->getByTitle();
                    ?>
                    <ul id="coming-soon-list">
                        <a href="movie.php?m=<?php echo $soonMovie1->id?>"><li>
                                <img class="list-img" src=<?php echo "\"img/movies/" . $soonMovie1->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $soonMovie1->title?></h4>
                                    <br/><?php echo getGenres($soonMovie1)?>
                                    <br/>
                                    <br/><?php echo dateConversion($soonMovie1->release_date);?>
                                </div>
                            </li></a>
                        <br>
                        <a href="movie.php?m=<?php echo $soonMovie2->id?>"><li class="clear">
                                <img class="list-img" src=<?php echo "\"img/movies/" . $soonMovie2->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $soonMovie2->title?></h4>
                                    <br/><?php echo getGenres($soonMovie2)?>
                                    <br/>
                                    <br/><?php echo dateConversion($soonMovie2->release_date);?>
                                </div>
                            </li></a>
                        <a href="movie.php?m=<?php echo $soonMovie3->id?>"><li class="clear">
                                <img class="list-img" src=<?php echo "\"img/movies/" . $soonMovie3->id . ".jpg\""?>/>
                            </li>
                            <li>
                                <div><h4><?php echo $soonMovie3->title?></h4>
                                    <br/><?php echo getGenres($soonMovie3)?>
                                    <br/>
                                    <br/><?php echo dateConversion($soonMovie3->release_date);?>
                                </div>
                            </li></a>
                    </ul>
                </section>
            </div>
        </main>
        <?php
        include('page-elements/footer.php');
        ?>
    </body>
</html>
