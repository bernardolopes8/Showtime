<?php
    require_once(dirname(__FILE__).'/../Controllers/Controller.php'); 
    $msg = Controller::process();
?>

<link href="css/header.css" rel="stylesheet" type="text/css"/>
<nav id="header">
            <a href="index.php"><img src="img/header/logo.png" alt="Showtime Logo" id="logo"/></a>
            <div id="search-form">
                <form method="get" action="search.php">
                    <input id="search-input" name="query" type="search" placeholder="What are you looking for?"/>
                    <select id="search-options" name="type">
                        <option value="movie">Movies</option>
                        <option value="people">People</option>
                    </select>
                    <input type="submit" id="search-submit" value=""/>
                </form>
            </div>
            <div id="user-menu" class="dropdown">
                <a 
                    <?php
                        if(UserController::getSessionUserId()) {
                    ?>
                    href="profile.php"
                    <?php
                        }
                        else {
                    ?>
                    href="login.php"
                    <?php
                        }
                    ?>
                    ><button class="dropdown-button" id="user-menu-button">
                        <?php
                            $user = UserController::getLoggedInUser();
                            if ($user == null) {
                                echo "Login/Register";
                            }
                            else {
                                if ($user->first_name != null) {
                                    echo "Hello, " . $user->first_name . "        ";
                                }
                                else {
                                    echo "Hello, " . $user->username . "        ";
                                }
                        ?>
                                <img src="img/header/user-menu.png"/>
                        <?php
                            }
                        ?>
                    </button></a>
                    <?php
                        if(UserController::getSessionUserId()) {
                    ?>
                    <div class="dropdown-content">
                        <a href="editprofile.php">Edit Profile</a>
                        <?php
                            if (UserController::isAdminLoggedIn()) {?>
                                <a href="admin.php">Admin Panel</a><?php
                            }
                        ?>
                        <form method="post" id="logout-form">
                            <input id="logout-input" type="submit" name="logout" value="Log Out"/>
                        </form>
                    </div>
                    <?php
                        }
                    ?>
            </div>
</nav>

