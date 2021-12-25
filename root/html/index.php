<?php
//mainpage document
//Include files
require_once "includes/errorHandler.inc.php";

session_start();
if(isset($_SESSION['uID'])){
    if(isset($_SESSION['admin'])){
        echo "<a href='admin.php'>Admin</a><br>";
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LBS Kreativa högskolan</title>
    </head>
    <body>
        <a href="profile.php">Profil</a>
        <a href='createClub.php'>Club</a>
        <a href='eventstuffs.php'>Event</a>
        <a href='clubs.php'>clubs</a>
    </body>
    </html>
<?php
} else{
?>   
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LBS Kreativa högskolan</title>
    </head>
    <body>
        <a href='login.php'>Login</a>

    </body>
    </html>
<?php
}?>