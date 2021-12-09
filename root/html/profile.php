<?php 
//profile document
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/errorHandler.inc.php";
require_once "includes/profileFunctions.inc.php";

session_start();
if(!isset($_SESSION['uID'])){
    header("location: ../html/index.php?error=notLogged");
    exit();
}
$uID = $_SESSION['uID'];

if(isset($_POST['chName'])){
    $nFName = $_POST['nFName'];
    $nLName = $_POST['nLName'];

    changeName($conn, $nFName, $nLName, $uID);
}
else if(isset($_POST['chEmail'])){
    $nEmail = $_POST['nEmail'];

    changeEmail($conn, $nEmail, $uID);
}
else if(isset($_POST['chPwd'])){
    $pwd = $_POST['pwd'];
    $nPwd = $_POST['nPwd'];
    $cNPwd = $_POST['cNPwd'];

    changePwd($conn, $pwd, $nPwd, $cNPwd, $uID);
}
else if(isset($_POST['delete'])){
    $dPwd = $_POST['dPwd'];
    $dCPwd = $_POST['cDPwd'];

    deleteUser($conn, $uID, $dPwd, $dCPwd);
}
else if(isset($_POST['logout'])){
    logout();
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
            <h1>Profile</h1>
            <div>
                <input type="submit" value="Change name" name="chName" id="but_submit" require/>
            </div>
                <div>
                    <input type="text" class="textbox" name="nFName" placeholder="New First Name" require/>
                </div>
                <div>
                    <input type="text" class="textbox" name="nLName" placeholder="New Last Name" require/>
                </div>
            <div>
                <input type="submit" value="Change email" name="chEmail" id="but_submit" require/>
            </div>
                <div>
                    <input type="text" class="textbox" name="nEmail" placeholder="New Email" require/>
                </div>
            <div>
                <input type="submit" value="Change Password" name="chPwd" id="but_submit" require/>
            </div>
                <div>
                    <input type="password" class="textbox" name="pwd" placeholder="Password" require/>
                </div>
                <div>
                    <input type="password" class="textbox" name="nPwd" placeholder="New Password" require/>
                </div>
                <div>
                    <input type="password" class="textbox" name="cNPwd" placeholder="Confirm New Password" require/>
                </div>
            <div>
                <input type="submit" value="Delete Account" name="delete" id="but_submit" require/>
            </div>
                <div>
                    <input type="password" class="textbox" name="dPwd" placeholder="Password" require/>
                </div>
                <div>
                    <input type="password" class="textbox" name="cDPwd" placeholder="Confirm Password" require/>
                </div>
            <div>
                <input type="submit" value="Logout" name="logout" id="but_submit" require/>
            </div>
        </div>
    </form>
</div>
</body>
</html>