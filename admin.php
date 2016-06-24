<!DOCTYPE html>

<html>
    <head>
        <link href="css/admin.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime - Admin</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/javascript">
            function addGenreToMovie() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        document.getElementById("add-genre-response").innerHTML = "<p>"+xhr.responseText+"</p><br/>";
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?movie-title="+document.getElementById("title-ajax").value+"&genre-name="
                        +document.getElementById("genre-ajax").value+"&action=addGenreToMovie", false);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
            
            function removeGenreFromMovie() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        document.getElementById("remove-genre-response").innerHTML = "<p>"+xhr.responseText+"</p><br/>";
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?movie-title="+document.getElementById("delete-title-ajax").value+"&genre-name="
                        +document.getElementById("delete-genre-ajax").value+"&action=removeGenreFromMovie", false);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
            
            function addPersonToMovie() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        document.getElementById("add-person-response").innerHTML = "<p>"+xhr.responseText+"</p><br/>";
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?movie-title="+document.getElementById("title-person-ajax").value+"&first-name="
                        +document.getElementById("first-name-ajax").value+"&last-name="+
                        document.getElementById("last-name-ajax").value+"&birthdate="+
                        document.getElementById("birthdate-ajax").value+"&role="+
                        document.getElementById("role-ajax").value+"&action=addPersonToMovie", false);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
            
            function removePersonFromMovie() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        document.getElementById("remove-person-response").innerHTML = "<p>"+xhr.responseText+"</p><br/>";
                    }
                }
                xhr.open("GET", "Controllers/AjaxController.php?movie-title="+document.getElementById("rem-title-person-ajax").value+"&first-name="
                        +document.getElementById("rem-first-name-ajax").value+"&last-name="+
                        document.getElementById("rem-last-name-ajax").value+"&birthdate="+
                        document.getElementById("rem-birthdate-ajax").value+"&role="+
                        document.getElementById("rem-role-ajax").value+"&action=removePersonFromMovie", false);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF8');
                xhr.send();
            }
        </script>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
            if (!UserController::isAdminLoggedIn()) {
                header("Location:notFound.php");
            }
            $indexContent = IndexController::getData();
        ?>
        <main>
            <div id="all">
                <div id="align">
                    <div id="refer">
                        <nav>
                            <h3>Go to</h3>
                            <button class="button"><a href="#">Main Page Content</a></button>
                            <button class="button"><a href="#user-type-go">Change user type</a></button>
                            <button class="button"><a href="#movie-go">Movie</a></button>
                            <button class="button"><a href="#person-go">Person</a></button>
                            <button class="button"><a href="#role-go">Role</a></button>
                            <button class="button"><a href="#country-go">Country</a></button>
                            <button class="button"><a href="#company-go">Company</a></button>
                            <button class="button"><a href="#genre-go">Genre</a></button>
                        </nav>
                    </div>
                </div>
                <?php
                            if (isset($msg['error'])) {
                                ?>
                        <div class="red-msg">
                            <?php
                                echo "<br/>";
                                foreach($msg['error'] as $error) {
                                    echo $error, "<br/>";
                                }
                                echo "<br/>";
                                ?>
                            </div>
                                <?php
                            }
                        ?>
                
                <!-- INDEX -->
                
                <div>
                    <h1>Main Page Content</h1>
                    <form method="post" enctype="multipart/form-data">
                        <label>Featured Movies</label><br/><br/>
                        <label>#1</label>
                        <input class="input" type="text" name="featured1" value="<?php echo $indexContent['featured'][0]?>"/>
                        <input type="file" name="featured1-img"/><br/><br/>
                        <label>#2</label>
                        <input class="input" type="text" name="featured2" value="<?php echo $indexContent['featured'][1]?>"/>
                        <input type="file" name="featured2-img"/><br/><br/>
                        <label>#3</label>
                        <input class="input" type="text" name="featured3" value="<?php echo $indexContent['featured'][2]?>"/>
                        <input type="file" name="featured3-img"/><br/><br/>
                        <label>#4</label>
                        <input class="input" type="text" name="featured4" value="<?php echo $indexContent['featured'][3]?>"/>
                        <input type="file" name="featured4-img"/><br/><br/>
                        <label>Top Movies of the Week</label><br/><br/>
                        <label>#1</label>
                        <input class="input" type="text" name="top1" value="<?php echo $indexContent['top'][0]?>"/><br/><br/>
                        <label>#2</label>
                        <input class="input" type="text" name="top2" value="<?php echo $indexContent['top'][1]?>"/><br/><br/>
                        <label>#3</label>
                        <input class="input" type="text" name="top3" value="<?php echo $indexContent['top'][2]?>"/><br/><br/>
                        <label>Coming Soon</label><br/><br/>
                        <label>#1</label>
                        <input class="input" type="text" name="soon1" value="<?php echo $indexContent['soon'][0]?>"/><br/><br/>
                        <label>#2</label>
                        <input class="input" type="text" name="soon2" value="<?php echo $indexContent['soon'][1]?>"/><br/><br/>
                        <label>#3</label>
                        <input class="input" type="text" name="soon3" value="<?php echo $indexContent['soon'][2]?>"/><br/><br/>
                        <input type="submit" name="update-index" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- USER TYPES -->
                
                <div>
                    <a id="user-type-go"><h1>Change user type</h1></a>
                    <form method="post">
                        <label>User email</label><br/>
                        <input class="input" type="email" name="user-email"/><br/><br/>
                        <input type="radio" name="user-type" value="1" checked> Regular User
                        <input type="radio" name="user-type" value="0"> Admin<br/><br/>
                        <input type="submit" name="change-user-type" class="button" value="Change type"/>
                    </form>
                </div>
                
                <!-- MOVIE -->
                
                <div id="movie">
                    <a id="movie-go"><h1>Add Movie</h1></a>
                    <form method="post" id="createMovie">
                        <label>Title</label><br/>
                        <input class="input" type="text" name="movie-title"/><br/><br/>
                        <label>Release Date</label><br/>
                        <input class="input" type="date" name="movie-date"/><br/><br/>
                        <label>Runtime (HH:mm)</label><br/>
                        <input class="input" type="text" name="movie-runtime"/><br/><br/>
                        <label>Trailer (Embed URL)</label><br/>
                        <input class="input" type="url" name="movie-trailer"/><br/><br/>
                        <label>Rating</label><br/>
                        <input class="input" type="text" name="movie-rating"/><br/><br/>
                        <label>Company</label><br/>
                        <select class="input" name="movie-company">
                            <option value="disabled">Company</option>
                            <?php 
                                $aux = new Company();
                                $company_list = $aux->getAll();
                                foreach ($company_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>Country</label><br/>
                        <select class="input" name="movie-country">
                            <option value="disabled">Country</option>
                            <?php 
                                $aux = new Country();
                                $country_list = $aux->getAll();
                                foreach ($country_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>Synopsys</label><br/>
                        <textarea form="createMovie" name="movie-synopsys"/></textarea><br/><br/>
                        <input type="submit" name="create-movie" class="button" value="Add"/>
                    </form>
                    <h1>Add genre to movie</h1>
                    <form method="get">
                        <div id="add-genre-response"></div>
                        <label>Movie title</label>
                        <input name="title-ajax" type="text" id="title-ajax"/><br/>
                        <label>Genre name</label>
                        <input name="genre-ajax" type="text" id="genre-ajax"/><br/><br/>
                        <input onclick="addGenreToMovie()" type="button" class="button" value="Add"/>
                    </form>
                    <h1>Remove genre from movie</h1>
                    <form method="get">
                        <div id="remove-genre-response"></div>
                        <label>Movie title</label>
                        <input name="delete-title-ajax" type="text" id="delete-title-ajax"/><br/>
                        <label>Genre name</label>
                        <input name="delete-genre-ajax" type="text" id="delete-genre-ajax"/><br/><br/>
                        <input type="button" class="button" value="Remove" onclick="removeGenreFromMovie()"/>
                    </form>
                    <h1>Add person to movie</h1>
                    <form method="get">
                        <div id="add-person-response"></div>
                        <label>Movie title</label>
                        <input name="title-person-ajax" type="text" id="title-person-ajax"/><br/>
                        <label>Person first name</label>
                        <input name="first-name-ajax" type="text" id="first-name-ajax"/><br/>
                        <label>Person last name</label>
                        <input name="last-name-ajax" type="text" id="last-name-ajax"/><br/>
                        <label>Person birthdate</label>
                        <input name="birthdate-ajax" type="date" id="birthdate-ajax"/><br/>
                        <label>Role name</label>
                        <input name="role-ajax" type="text" id="role-ajax"/><br/><br/>
                        <input onclick="addPersonToMovie()" type="button" class="button" value="Add"/>
                    </form>
                    <h1>Remove person from movie</h1>
                    <form method="get">
                        <div id="remove-person-response"></div>
                        <label>Movie title</label>
                        <input name="rem-title-person-ajax" type="text" id="rem-title-person-ajax"/><br/>
                        <label>Person first name</label>
                        <input name="rem-first-name-ajax" type="text" id="rem-first-name-ajax"/><br/>
                        <label>Person last name</label>
                        <input name="rem-last-name-ajax" type="text" id="rem-last-name-ajax"/><br/>
                        <label>Person birthdate</label>
                        <input name="rem-birthdate-ajax" type="date" id="rem-birthdate-ajax"/><br/>
                        <label>Role name</label>
                        <input name="rem-role-ajax" type="text" id="rem-role-ajax"/><br/><br/>
                        <input onclick="removePersonFromMovie()" type="button" class="button" value="Remove"/>
                    </form>
                    <h1>Delete Movie</h1>
                    <form method="post">
                        <label>Title</label><br/>
                        <input class="input" type="text" name="title-delete"/><br/><br/>
                        <input type="submit" name="delete-movie" class="button" value="Delete"/>
                    </form>
                    <h1>Update Movie</h1>
                    <form method="post" id="updateMovie" enctype="multipart/form-data">
                        <label>Title to update</label><br/>
                        <input class="input" type="text" name="movie-title-old"/><br/><br/>
                        <label>Movie Poster</label><br/>
                        <input type="file" name="movie-img"/><br/><br/>
                        <label>New Title</label><br/>
                        <input class="input" type="text" name="movie-title-new"/><br/><br/>
                        <label>New Release Date</label><br/>
                        <input class="input" type="date" name="movie-date-new"/><br/><br/>
                        <label>New Runtime (HH:mm)</label><br/>
                        <input class="input" type="text" name="movie-runtime-new"/><br/><br/>
                        <label>New Trailer (Embed URL)</label><br/>
                        <input class="input" type="url" name="movie-trailer-new"/><br/><br/>
                        <label>New Rating</label><br/>
                        <input class="input" type="text" name="movie-rating-new"/><br/><br/>
                        <label>New Company</label><br/>
                        <select class="input" name="movie-company-new">
                            <option value="disabled">Company</option>
                            <?php 
                                $aux = new Company();
                                $company_list = $aux->getAll();
                                foreach ($company_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>New Country</label><br/>
                        <select class="input" name="movie-country-new">
                            <option value="disabled">Country</option>
                            <?php 
                                $aux = new Country();
                                $country_list = $aux->getAll();
                                foreach ($country_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>New Synopsys</label><br/>
                        <textarea form="updateMovie" name="movie-synopsys-new"/></textarea><br/><br/>
                        <input type="submit" name="update-movie" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- PERSON -->
                
                <div id="person">
                    <a id="person-go"><h1>Add Person</h1></a>
                    <form method="post" id="add-person">
                        <label>First Name</label><br/>
                        <input class="input" type="text" name="person-first-name"/><br/><br/>
                        <label>Last Name</label><br/>
                        <input class="input" type="text" name="person-last-name"/><br/><br/>
                        <label>Birthdate</label><br/>
                        <input class="input" type="date" name="person-birthdate"/><br/><br/>
                        <label>Country Name</label><br/>
                        <select class="input" name="person-country">
                            <option value="disabled">Country</option>
                            <?php 
                                $aux = new Country();
                                $country_list = $aux->getAll();
                                foreach ($country_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>Biography</label><br/>
                        <textarea form="add-person" name="person-biography"/></textarea><br/><br/>
                        <input type="submit" name="create-person" class="button" value="Add"/>
                    </form>
                    <h1>Delete Person</h1>
                    <form method="post">
                        <label>First Name</label><br/>
                        <input class="input" type="text" name="person-first-delete"/><br/><br/>
                        <label>Last Name</label><br/>
                        <input class="input" type="text" name="person-last-delete"/><br/><br/>
                        <label>Birthdate</label><br/>
                        <input class="input" type="date" name="person-birthdate-delete"/><br/><br/>
                        <input type="submit" name="delete-person" class="button" value="Delete"/>
                    </form>
                    <h1>Update Person</h1>
                    <form method="post" id="update-person" enctype="multipart/form-data">
                        <label>First name to update</label><br/>
                        <input class="input" type="text" name="first-name-update-old"/><br/><br/>
                        <label>Last name to update</label><br/>
                        <input class="input" type="text" name="last-name-update-old"/><br/><br/>
                        <label>Birthdate to update</label><br/>
                        <input class="input" type="date" name="birthdate-update-old"/><br/><br/>
                        <label>Person Picture</label><br/>
                        <input type="file" name="person-img"/><br/><br/>
                        <label>New first name</label><br/>
                        <input class="input" type="text" name="first-name-update-new"/><br/><br/>
                        <label>New last name</label><br/>
                        <input class="input" type="text" name="last-name-update-new"/><br/><br/>
                        <label>New birthdate</label><br/>
                        <input class="input" type="date" name="birthdate-update-new"/><br/><br/>
                        <label>New country</label><br/>
                        <select class="input" name="person-country-update">
                            <option value="disabled">Country</option>
                            <?php 
                                $aux = new Country();
                                $country_list = $aux->getAll();
                                foreach ($country_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select><br/><br/>
                        <label>New biography</label><br/>
                        <textarea form="update-person" name="biography-update-new"/></textarea><br/><br/>
                        <input type="submit" name="update-person" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- ROLE -->
                
                <div id="role">
                    <a id="role-go"><h1>Add Role</h1></a>
                    <form method="post">
                        <label>Role Name</label><br/>
                        <input class="input" type="text" name="role-name"/><br/><br/>
                        <input type="submit" name="create-role" class="button" value="Add"/>
                    </form>
                    <h1>Delete Role</h1>
                    <form method="post">
                        <label>Role Name</label><br/>
                        <input class="input" type="text" name="role-delete"/><br/><br/>
                        <input type="submit" name="delete-role" class="button" value="Delete"/>
                    </form>
                    <h1>Update Role</h1>
                    <form method="post">
                        <label>Role to update</label><br/>
                        <input class="input" type="text" name="role-update-old"/><br/><br/>
                        <label>New name</label><br/>
                        <input class="input" type="text" name="role-update-new"/><br/><br/>
                        <input type="submit" name="update-role" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- COUNTRY -->
                
                <div id="country">
                    <a id="country-go"><h1>Add Country</h1></a>
                    <form method="post">
                        <label>Country Name</label><br/>
                        <input class="input" type="text" name="country-name"/><br/><br/>
                        <input type="submit" name="create-country" class="button" value="Add"/>
                    </form>
                    <h1>Delete Country</h1>
                    <form method="post">
                        <label>Country Name</label><br/>
                        <input class="input" type="text" name="country-delete"/><br/><br/>
                        <input type="submit" name="delete-country" class="button" value="Delete"/>
                    </form>
                    <h1>Update Country</h1>
                    <form method="post">
                        <label>Country to update</label><br/>
                        <input class="input" type="text" name="country-update-old"/><br/><br/>
                        <label>New name</label><br/>
                        <input class="input" type="text" name="country-update-new"/><br/><br/>
                        <input type="submit" name="update-country" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- COMPANY -->
                
                <div id="company">
                    <a id="company-go"><h1>Add Company</h1></a>
                    <form method="post">
                        <label>Company Name</label><br/>
                        <input class="input" type="text" name="company-name"/><br/><br/>
                        <input type="submit" name="create-company" class="button" value="Add"/>
                    </form>
                    <h1>Delete Company</h1>
                    <form method="post">
                        <label>Company Name</label><br/>
                        <input class="input" type="text" name="company-delete"/><br/><br/>
                        <input type="submit" name="delete-company" class="button" value="Delete"/>
                    </form>
                    <h1>Update Company</h1>
                    <form method="post">
                        <label>Company to update</label><br/>
                        <input class="input" type="text" name="company-update-old"/><br/><br/>
                        <label>New name</label><br/>
                        <input class="input" type="text" name="company-update-new"/><br/><br/>
                        <input type="submit" name="update-company" class="button" value="Update"/>
                    </form>
                </div>
                
                <!-- GENRE -->
                
                <div id="genre">
                    <a id="genre-go"><h1>Add Genre</h1></a>
                    <form method="post">
                        <label>Genre Name</label><br/>
                        <input class="input" type="text" name="genre-name"/><br/><br/>
                        <input onclick="createGenre()" type="submit" name="create-genre" class="button" value="Add"/>
                    </form>
                    <h1>Delete Genre</h1>
                    <form method="post">
                        <label>Genre Name</label><br/>
                        <input class="input" type="text" name="genre-delete"/><br/><br/>
                        <input type="submit" name="delete-genre" class="button" value="Delete"/>
                    </form>
                    <h1>Update Genre</h1>
                    <form method="post">
                        <label>Genre to update</label><br/>
                        <input class="input" type="text" name="genre-update-old"/><br/><br/>
                        <label>New name</label><br/>
                        <input class="input" type="text" name="genre-update-new"/><br/><br/>
                        <input type="submit" name="update-genre" class="button" value="Update"/>
                    </form>
                </div>
            </div>
        </main>
        <?php
        include('page-elements/footer.php');
        ?>
    </body>
</html>