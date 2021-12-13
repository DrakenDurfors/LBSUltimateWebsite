<?php 
//Error handler. Make sure to change echo into a popup screen instead later
    if(isset($_GET['error'])){
        switch($_GET['error']){
            case "loginError":
                echo "Your password or email might be wrong";
                echo "<br>";
                break;
            case "fieldError":
                echo "Make sure to fill in all relevant fields";
                echo "<br>";
                break;
            case "invalidEmail":
                echo "Make sure to enter a valid email address";
                echo "<br>";
                break;
            case "userExist":
                echo "That Email is already taken";
                echo "<br>";
                break;
            case "stmtFailed":
                echo "Something went wrong, too bad!";
                echo "<br>";
                break;
            case "notLogged":
                echo "You need to be logged in to access that page";
                echo "<br>";
                break;
            case "logged":
                echo "You've already logged in";
                echo "<br>";
                break;
            case "unmatchingPwd":
                echo "Your password is incorrect, try again";
                echo "<br>";
                break;
            case "confirmErr":
                echo "Your password doesnt match the confirmation password";
                echo "<br>";
                break;
            case "samePwd":
                echo "Your new password is the same as your old password";
                echo "<br>";
                break;
        }
    }
    if(isset($_GET['success'])){
        switch($_GET['success']){
            case "changeName":
                echo "You sucessfully changed your name";
                echo "<br>";
                break;
            case "changeEmail":
                echo "You sucessfully changed your email";
                echo "<br>";
                break;
            case "changePwd":
                echo "You sucessfully changed your password";
                echo "<br>";
                break;
            case "logout":
                echo "You sucessfully logged out";
                echo "<br>";
                break;
            case "deleteUser":
                echo "Account has been deleted";
                echo "<br>";
                break;
        }
    }
?>