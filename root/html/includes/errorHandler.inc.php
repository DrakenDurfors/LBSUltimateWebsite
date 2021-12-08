<?php 
//Error handler. Make sure to change echo into a popup screen instead later
    if(isset($_GET['error'])){
        switch($_GET['error']){
            case "loginError":
                echo "Your password or email might be wrong";
                break;
            case "signupError":
                echo "Make sure to fill in all fields";
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
        }
    }
?>