<!DOCTYPE html>

<html>
    <head>
        <link href="css/notFound.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
        include('page-elements/header.php');
        ?>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <main>
            <div id="all">
                <img src="img/misc/404.png" alt="404 Not Found"/>
                <h2>Can't find the requested page</h3>
                    <p>The page you requested doesn't exist or you do not have permission to access it. Please check the URL or <a onClick="goBack()"><span class="back">go back</span></a></p>
            </div>
        </main>
        <?php
        include('page-elements/footer.php');
        ?>
    </body>
</html>