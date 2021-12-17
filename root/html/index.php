<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>LBS Kreativa högskolan</title>
</head>
<body>
    <img class="loggo" src="../images/LBS_logo_CMYK_SVART.png" alt="">
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

        <a href="profile.php">Profil</a>

    <?php
    } else{
    ?>   
        <div class="videoPanel">
            <div class="frontBold">
            STOCKHOLM SÖDRAS<br>KLUBBAR &<br>EVENT
            </div>
            <div class="videoLogged">
                <video autoplay muted loop>
                    <source src="../images/VidLoop.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        
        <div class="rightTopBtn">
            <a class="btn" href='login.php'>LOGGA IN</a>
            <a class="btn" href='signup.php'>SKAPA KONTO</a>
        </div>

    <?php
    }?>
</body>
</html>