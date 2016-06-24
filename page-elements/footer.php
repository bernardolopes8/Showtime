<link href="css/footer.css" rel="stylesheet" type="text/css"/>

<footer>
    <nav>
        <ul>
            <a href="index.php"><li>Home</li></a>
            <a href="#"><img id="backtop" src="img/footer/top.png" alt="Back to Top"/></a>
            <li id="copyright">Copyright © Showtime 2016</li>
            <?php
                if (UserController::isAdminLoggedIn()) {?>
                        <a href="admin.php"><li>Admin Panel</li></a><?php
                }
            ?>
        </ul>
    </nav>
</footer>

