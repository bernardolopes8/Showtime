<!DOCTYPE html>

<?php
    require_once(dirname(__FILE__).'/Controllers/Controller.php'); 
    $msg = Controller::process();
    if (isset($_GET['type']) && isset($_GET['query'])) {
        $query = $_GET['query'];
        if ($_GET['type'] == 'movie') {
            $movie_aux = new Movie();
            $movie_aux->title = $query;
            $movie_results = $movie_aux->searchByTitle();
        }
        else if ($_GET['type'] == 'people') {
            $person_aux = new Person();
            $person_aux->first_name = $query;
            $person_results = $person_aux->searchByName();
        }
        else {
            header('Location:notFound.php');
        }
    }
    else {
        header('Location:notFound.php');
    }
?>

<html>
 <head>
     <link href="css/search.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime - Search Results</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
            function getYear($date) {
                $exploded = explode('-', $date);
                return $exploded[0];
            }
        ?>
        <main>
            <div id="all">
                <h1>Search results for "<?php echo $query;?>"</h1>
                
                <?php
                if ($_GET['type'] == 'movie') { if ($movie_results) {?>
                <table id="movie">
                    <h1 class="tablet">Movies</h1>
                    <?php 
                        foreach ($movie_results as $obj=>$attr) {
                            if (isset ($attr->release_date)) { $year = getYear($attr->release_date);} else {$year = "";}
                            $poster = 'img/movies/' . $attr->id_movie . '.jpg';
                            if (!file_exists($poster)) {
                            $poster = 'img/misc/placeholder-poster.png';
                            }
                            echo '<tr><td><a href="movie.php?m=' . $attr->id_movie . '"><img class="matrix-img" src="' . $poster . 
                                    '"/></a></td><td><a href="movie.php?m=' . $attr->id_movie . '">' . $attr->title . '</a></td><td>' . $year . '</td></tr>';
                        }
                    ?>
                </table>
                <?php } } else if ($_GET['type'] == 'people') { if ($person_results) {?>
                <table id="person">
                    <h1 class="table_t">People</h1>
                    <?php 
                        foreach ($person_results as $obj=>$attr) {
                            if (isset ($attr->birthdate)) { $year = getYear($attr->birthdate);} else {$year = "";}
                            $avatar = 'img/people/' . $attr->id_person . '.jpg';
                            if (!file_exists($avatar)) {
                            $avatar = 'img/misc/placeholder-avatar.png';
                            }
                            echo '<tr><td><a href="person.php?p=' . $attr->id_person . '"><img class="matrix-img" src="' . $avatar . 
                                    '"/></a></td><td><a href="person.php?p=' . $attr->id_person . '">' . $attr->first_name . ' ' . $attr->last_name . '</a></td><td>' . $year . '</td></tr>';
                        }
                    ?>
                </table>
                <?php } } else {
                    if ($_GET['type'] == 'movie') {
                        echo '<h3>No movies were found!</h3>';
                    }
                    else if ($_GET['type'] == 'people') {
                        echo '<h3>No people were found!</h3>';
                    }
                    }?>
            </div>
        </main>
        <?php
            include('page-elements/footer.php');
        ?>
    </body>
       