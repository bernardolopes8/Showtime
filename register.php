<!DOCTYPE html>

<html>
    <head>
        <link href="css/register.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime - Register</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
        include('page-elements/header.php');
        if (UserController::getSessionUserId()) {
            header("Location:index.php");
        }
        ?>
        <main>
            <div id="all">
                <div id="sig">
                    <br/>
                    <p class="red-msg">Signup with Showtime!</p>
                </div>
                <div id="username">
                    <form method="post">
                        <?php
                        if (isset($msg['error'])) {
                            ?>
                            <div class="red-msg">
                                <?php
                                echo "<br/>";
                                foreach ($msg['error'] as $error) {
                                    echo $error, "<br/>";
                                }
                                echo "<br/>";
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <label>Username <span class="red-msg">*</span></label>
                        <input class="in" type="text" name="username" value="<?php if (isset($_SESSION['register-username'])) {
                            echo $_SESSION['register-username'];
                        } ?>">
                        <br/>
                        <label>Password <span class="red-msg">*</span></label>
                        <input class="in" type="password" name="password">
                        <br/>
                        <label>Retype password <span class="red-msg">*</span></label>
                        <input class="in" type="password" name="password_validation">
                        <br/>
                        <label>Email <span class="red-msg">*</span></label>
                        <input class="in" type="email" name="email" value="<?php if (isset($_SESSION['register-email'])) {
                            echo $_SESSION['register-email'];
                        } ?>">
                        <br/>
                        <label>Country</label>
                        <select class="in" name="country">
                            <option value="disabled" name="country">Country</option>
                            <?php
                            $aux = new Country();
                            $country_list = $aux->getAll();
                            foreach ($country_list as $id => $name) {
                                ?>
                                <option value="<?php echo $id ?>"><?php echo $name ?></option><?php
                            }
                            ?>
                        </select>
                        <br/>
                        <label>First Name</label>
                        <input class="in" type="text" name="firstname" value="<?php if (isset($_SESSION['register-firstname'])) {
                                echo $_SESSION['register-firstname'];
                            } ?>">
                        <br/>
                        <label>Last Name</label>
                        <input class="in" type="text" name="lastname" value="<?php if (isset($_SESSION['register-lastname'])) {
                                echo $_SESSION['register-lastname'];
                            } ?>">
                        <br/>
                        <label>Birthdate</label>
                        <input class="in" type="date" name="birthdate" value="<?php if (isset($_SESSION['register-birthdate'])) {
                                echo $_SESSION['register-birthdate'];
                            } ?>">
                        <br/>
                        <br/>
                        <input class="button" type="submit" name="register" value="Register"/>
                    </form>
                </div>
                <div id="login">
                    <form action="login.php">
                        <label>Already have an account?</label>
                        <button class="button">Login</button>
                    </form>
                </div>
            </div>
        </main>
<?php
include('page-elements/footer.php');
?>
    </body>
</html>