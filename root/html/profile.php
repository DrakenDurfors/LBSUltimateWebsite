<?php 
//profile document
//Include files
require_once "includes/errorHandler.inc.php";
require_once "includes/functions.inc.php";

session_start();
if(!isset($_SESSION['uID'])){
    header("location: ../html/index.php?error=notLogged");
    exit();
}

if(isset($_POST['chName'])){
    echo "name change";
}
else if(isset($_POST['chEmail'])){
    echo "email change";
}
else if(isset($_POST['chPwd'])){
    echo "pwd change";
}
else if(isset($_POST['delete'])){
    echo "delete";
}
else if(isset($_POST['logout'])){
    echo "logout";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
<div class="container">
    <form method="post" action="#">
        <div id="div_profile">
            <h1>Login</h1>
            <div>
                <input type="submit" value="Change name" name="chName" id="but_submit" require/>
            </div>
            <div>
                <input type="submit" value="Change email" name="chEmail" id="but_submit" require/>
            </div>
            <div>
                <input type="submit" value="Change Password" name="chPwd" id="but_submit" require/>
            </div>
            <div>
                <input type="submit" value="Delete Account" name="delete" id="but_submit" require/>
            </div>
            <div>
                <input type="submit" value="Logout" name="logout" id="but_submit" require/>
            </div>
        </div>
    </form>
</div>
</body>
</html>