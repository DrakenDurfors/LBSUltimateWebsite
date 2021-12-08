<?php 
//Error handler. Make sure to change echo into a popup screen instead later
    if(isset($_GET['error'])){
        switch($_GET['error']){
            case "loginError":
                echo "Your password or email might be wrong";
                break;
            case "fieldError":
                echo "Make sure to fill in all relevant fields";
                break;
            case "invalidEmail":
                echo "Make sure to enter a valid email address";
                break;
            case "userExist":
                echo "That Email is already taken";
                break;
            case "stmtFailed":
                echo "Something went wrong, too bad!";
                break;
            case "notLogged":
                echo "You need to be logged in to access that page";
                break;
            case "logged":
                echo "You've already logged in";
                break;
            case "unmatchingPwd":
                echo "Your password is incorrect, try again";
                break;
            case "confirmErr":
                echo "Your new password doesnt match the confirmation password";
                break;
            case "samePwd":
                echo "Your new password is the same as your old password";
                break;
        }
    }
    if(isset($_GET['success'])){
        switch($_GET['success']){
            case "changeName":
                echo "You sucessfully changed your name";
                break;
            case "changeEmail":
                echo "You sucessfully changed your email";
                break;
            case "changePwd":
                echo "You sucessfully changed your password";
                break;
        }
    }
?>