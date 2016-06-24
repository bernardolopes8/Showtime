<!DOCTYPE html>

<?php
    require_once(dirname(__FILE__).'/Controllers/Controller.php'); 
    $msg = Controller::process();
    if(UserController::getSessionUserId()) {
        $user = UserController::getLoggedInUser();
        $user_id = $user->id;
    }
    else {
         header("Location:notFound.php");
    }
?>
<html>
 <head>
     <link href="css/profile.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>
            <?php 
                if ($user->first_name != null && $user->last_name != null) {
                    echo $user->first_name . " " . $user->last_name;
                }
                else {
                    echo $user->username;
                }
            ?>
        </title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
        ?>
        <main>
            <div id="all">
                <?php
                        $avatar = 'img/user-avatars/' . $user_id . '.jpg';
                        if (!file_exists($avatar)) {
                            $avatar = 'img/misc/placeholder-avatar.png';
                        }
                    ?>
                <img id="profile-img" src="<?php echo $avatar?>" alt="Avatar"/>    
                <div id="details">
                    <br/><span class="red">Name: </span>
                    <?php 
                        $first = $user->first_name;
                        $last = $user->last_name;
                        if ($first == null && $last == null)
                        {
                            echo "N/A";
                        }
                        else {
                            echo $first . " " . $last;
                        }
                    ?>
                    <br/><span class="red">Username: </span>
                    <?php 
                        echo $user->username;
                    ?>
                    <br/><span class="red">Age: </span>
                    <?php
                        $birthdate = new DateTime($user->birthdate);
                        $currentdate = new DateTime();
                        $interval = $birthdate->diff($currentdate);
                        echo $interval->format('%y years old');
                    ?>
                    <br/><span class="red">Country: </span>
                    <?php
                        $id = $user->country;
                        $country_name = CountryController::getCountryName($id);  
                        echo $country_name;
                    ?>
                </div>
                <div id="img">
                    <h1>Watchlist</h1>
                    <?php
                        $aux = new Watchlist();
                        $aux->user = $user_id;
                        $watchlist = $aux->getByUser();
                        if ($watchlist) {
                            foreach ($watchlist as $object=>$ids) {
                                echo '<a href="movie.php?m=' . $ids->movie_id_movie . '"><div class="item"><p>' . MovieController::getTitle($ids->movie_id_movie) . '</p><img class="watched-img" src="img/movies/' . $ids->movie_id_movie . 
                                        '.jpg" alt="' . MovieController::getTitle($ids->movie_id_movie) . '"/></div></a>';
                            }
                        }
                        else {
                            echo '<h3>No movies yet!</h3>';
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