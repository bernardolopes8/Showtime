<!DOCTYPE html>

<?php
    require_once(dirname(__FILE__).'/Controllers/Controller.php'); 
    $msg = Controller::process();
    if (isset($_GET['p'])) {
                $id = $_GET['p'];
                $person = new Person();
                $person->id = $id;
                if (!$person->getById()) {
                    header('Location:notFound.php');
                }
            }else{
                header('Location:notFound.php');
            }
?>

<html>
 <head>
     <link href="css/person.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title><?php echo $person->first_name . " " . $person->last_name;?></title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
        ?>
        <main>
            <div id="all">
            <div id="left">
                <h1><?php echo $person->first_name . " " . $person->last_name;?></h1>
                <?php
                        $avatar = 'img/people/' . $person->id . '.jpg';
                        if (!file_exists($avatar)) {
                            $avatar = 'img/misc/placeholder-avatar.png';
                        }
                    ?>
                <img class="person-img" src="<?php echo $avatar?>"/>
                <?php 
                if(isset($person->birthdate)) {
                    $dates = explode('-', $person->birthdate);
                    $year = $dates[0];
                    $month = $dates[1];
                    $day = $dates[2];
                }
                
                if(isset($person->country)) {
                        $country = CountryController::getCountryName($person->country);
                    }
                ?>
                <p><span class="red">» Born:</span> <?php if(isset($person->birthdate)) {echo $day . '/' . $month . '/' . $year;} else {echo "Unknown";}?></p>
                <p><span class="red">» Country:</span> <?php if(isset($country)) {echo $country;} else {echo "Unknown";}?></p>
            </div>
                <?php 
                    $mpr = new MPR();
                    $mpr->person = $person->id;
                    $roles = $mpr->getByPerson();
                ?>
            <div id="right">
                <h1>Biography</h1>
                <p class="pr"><?php if(isset($person->biography)) {echo $person->biography;} else {echo "No biography yet";}?></p>
                <p class="pr"><span class="red">Appears in: </span>
                    <?php
                        if ($roles) {
                            echo '</p><table id="table">';
                            foreach ($roles as $p=>$mr) {
                                echo '<tr><td><a class="movie-link" href="movie.php?m=' . $mr->movie_id_movie . '">' .
                                        MovieController::getTitle($mr->movie_id_movie) . "</a></td><td>" . 
                                        RoleController::getName($mr->role_id_role) . "</td></tr>";
                            }
                            echo '</table>';
                        }
                        else {
                            echo "No movies yet</p>";
                        }
                    ?>
            </div>
            </div>
        </main>
        <?php
            include('page-elements/footer.php');
        ?>
    </body>
        </html>