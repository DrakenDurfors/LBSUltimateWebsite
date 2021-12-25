<!-- MainPage document -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>LBS Kreativa högskolan</title>
</head>
<body>
    <!-- Loggo in top left -->
    <img class="loggo" src="../images/LBS_logo_CMYK_SVART.png" alt="">
    <?php
    //Include files
    require_once "includes/errorHandler.inc.php";

    session_start();
    if(isset($_SESSION['uID'])){
        ?>
            <!-- Video Panel + text when logged in -->
            <header class="videoPanelLogged">
                <div class="frontBold">
                STOCKHOLM SÖDRAS<br>KLUBBAR &<br>EVENT
                </div>
                <div class="overlay"></div>
                <video autoplay muted loop>
                    <source src="../images/VidLoop.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </header>
            
            <!-- Buttons at top right -->
            <div class="rightTopBtn">
                <a class="btn" href="profile.php">PROFIL</a>
                <a class="btn" href="clubs.php">KLUBBAR</a>
                <?php
                // Checks if user is an admin and adds an admin page
                if(isset($_SESSION['admin'])){
                    echo "<a class='btn' href='admin.php'>ADMIN</a><br>";
                }?>
            </div>
        <?php
    } else{
        ?>   
            <!-- Video Panel + text when not logged in -->
            <header class="videoPanel">
                <div class="frontBold">
                STOCKHOLM SÖDRAS<br>KLUBBAR &<br>EVENT
                </div>
                <video autoplay muted loop>
                    <source src="../images/VidLoop.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </header>
            
            <div class="rightTopBtn">
                <a class="btn" href='login.php'>LOGGA IN</a>
                <a class="btn" href='signup.php'>SKAPA KONTO</a>
            </div>
        <?php
    }?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <?php require_once "includes/footer.inc.php";?>
</body>
</html>