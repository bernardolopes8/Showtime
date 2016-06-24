<!DOCTYPE html>

<head>
    <link href="css/login.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="img/main/favicon.ico"/>
    <title>Showtime - Login</title>
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
            <div id="log">
                <h1>Login</h1>
            </div>
            <div id="center">
                <?php
                if (isset($msg['error'])) {
                    echo "<br/>";
                    foreach ($msg['error'] as $error) {
                        echo $error, "<br/>";
                    }
                    echo "<br/>";
                }
                ?>
                <form method="post">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php if (isset($_SESSION['login-email'])) {
                    echo $_SESSION['login-email'];
                } ?>"/>
                    <br/>
                    <label>Password</label>
                    <input type="password" name="password"/>
                    <br/>
                    <input class="button" type="submit" name="login" value="Login"/>
                </form>
                <div id="logout">
                    <form action="profile.php">

                    </form>
                </div>
                <div id="register">
                    <form action="register.php">
                        <button class="button">Don't have an account? Register</button>
                    </form>
                </div
            </div>
        </div>
    </main>
    <?php
    include('page-elements/footer.php');
    ?>
</body>
</html>