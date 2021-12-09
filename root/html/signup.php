<?php
//Signup page
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/functions.inc.php";
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
    <title>Signup</title>
</head>
<body>
<div class="container">
    <form method="post" action="#">
        <div id="div_signup">
            <h1>Sign Up</h1>
            <div>
                <input type="text" class="textbox" name="fName" placeholder="First Name" require/>
            </div>
            <div>
                <input type="text" class="textbox" name="lName" placeholder="Last Name" require/>
            </div>
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
        <a href="login.php">Already have an account?</a>
    </div>
</div>
</body>
</html>