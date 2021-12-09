<?php
//Login page
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/profileFunctions.inc.php";
require_once "includes/errorHandler.inc.php";

session_start();
if(isset($_SESSION['uID'])){
    header("location: ../html/index.php?error=logged");
    exit();
}

if(isset($_POST['email'])){
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    loginUser($conn, $email, $pwd);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="container">
    <form method="post" action="#">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" name="email" placeholder="Email" require/>
            </div>
            <div>
                <input type="password" class="textbox" name="pwd" placeholder="Password" require/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" require/>
            </div>
        </div>
    </form>
    <div>
        <a href="signup.php">Sign up?</a>
    </div>
</div>
</body>
</html>