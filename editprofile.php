<!DOCTYPE html>

<html>
 <head>
     <link href="css/editprofile.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/main/favicon.ico"/>
        <title>Showtime - Edit Profile</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
            include('page-elements/header.php');
            if(UserController::getSessionUserId()) {
                $user = UserController::getLoggedInUser();
                $user_id = $user->id;
            }
            else {
                header("Location:notFound.php");
            }
        ?>
        <main>
            <div id="all">
                <div id="editl">
                <div id="changeA">
                    <?php
                        $avatar = 'img/user-avatars/' . $user_id . '.jpg';
                        if (!file_exists($avatar)) {
                            $avatar = 'img/misc/placeholder-avatar.png';
                        }
                    ?>
                    <img id="profile-img" src="<?php echo $avatar?>" alt="Avatar"/> 
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="userAvatar" id="fileToUpload"/>
                        <br/>
                        <input id="img-upload-btn" class="upload-button" type="submit" value="Change Avatar" name="img-upload"/>
                    </form>
                </div>
                <form method="post">
                    <br/>
                    <label>Current Password</label>
                    <br/>
                    <input class="in" type="password" name="currentpass"/>
                    <br/>
                    <label>Enter New Password</label>
                    <br/>
                    <input class="in" type="password" name="newpass"/>
                    <br/>
                    <label>Confirm New Password</label>
                    <br/>
                    <input class="in" type="password" name="confirmpass"/>
                    <br/>
                    <br/>
                    <input class="button" type="submit" name="save-password" value="Save"/>
                </form>
                </div>
                <div id="editr">
                    <form method="post">
                        <br/>
                        <label>Current Email</label>
                        <br/>
                        <input class="in" type="email" name="currentemail"/>
                        <br/>
                        <label>Enter New Email</label>
                        <br/>
                        <input class="in" type="email" name="newemail"/>
                        <br/>
                        <label>Confirm New Email</label>
                        <br/>
                        <input class="in" type="email" name="confirmemail"/>
                        <br/>
                        <br/>
                        <input class="button" type="submit" name="save-email" value="Save"/>
                    </form>
                    <form method="post">
                        <br/>
                        <label>First Name</label>
                        <br/>
                        <input class="in" type="text" name="first_name" value="<?php if(isset(UserController::getLoggedInUser()->first_name)) {echo UserController::getLoggedInUser()->first_name;}?>"/>
                        <br/>
                        <label>Last Name</label>
                        <br/>
                        <input class="in" type="text" name="last_name" value="<?php if(isset(UserController::getLoggedInUser()->last_name)) {echo UserController::getLoggedInUser()->last_name;}?>"/>
                        <br/>
                        <label>Birthdate</label>
                        <br/>
                        <input class="in" type="date" name="birthdate" value="<?php if(isset(UserController::getLoggedInUser()->birthdate)) {echo UserController::getLoggedInUser()->birthdate;}?>"/>
                        <br/>
                        <label>Country</label>
                        <br/>
                        <select class="in" name="country">
                            <option value="disabled" name="country">Country</option>
                            <?php 
                                $aux = new Country();
                                $country_list = $aux->getAll();
                                foreach ($country_list as $id=>$name) {?>
                                    <option value="<?php echo $id?>"><?php echo $name?></option><?php
                                }
                            ?>
                        </select>
                        <br/>
                        <input class="button" type="submit" name="save-personalinfo" value="Save"/>
                    </form>
                </div>
            </div>
        </main>
        <?php
            include('page-elements/footer.php');
        ?>
    </body>
       