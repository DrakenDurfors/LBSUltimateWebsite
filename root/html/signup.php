<?php
//Signup page
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/profileFunctions.inc.php";
require_once "includes/errorHandler.inc.php";

if(isset($_POST['email'])){
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    insertUser($conn, $fName, $lName, $email, $pwd);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Signup</title>
</head>
<body>
    <div class="topBanner GUL">
    <a href="../html">
        <img class="loggo" src="../images/LBS_logo_CMYK_SVART.png" alt="">
    </a>
    </div>
    <div class="container GRÅ GUL_TXT">
        <h1>SKAFFA KONTO</h1>
        <hr>
        <div class="inBox">
            <form method="post" action="#">
                <div id="div_signup">
                    <input type="text" class="textbox" name="fName" placeholder=" FÖRNAMN" required/>
                    <input type="text" class="textbox" name="lName" placeholder=" EFTERNAMN" required/>
                    <input type="text" class="textbox" name="email" placeholder=" EMAIL" required/>
                    <input type="password" class="textbox" name="pwd" placeholder=" LÖSENORD" required/>
                    <input class="btn VIOLETT left" type="submit" value="Submit" name="but_submit" id="but_submit" required/>
                </div>
            </form>
            <div>
                <a class="btn ROSA right" href="login.php">HAR KONTO ></a>
            </div>
        </div>
    </div>
</body>
</html>