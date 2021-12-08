<?php
//functions page

//Check if user exists in DB
function userExist($conn, $email){
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        return $row;
        mysqli_stmt_close($stmt);
    }
    else{
        return false;
        mysqli_stmt_close($stmt);
    }
}

//login user
function loginUser($conn, $email, $pwd){
    $userExists = userExist($conn, $email);
    
    if($userExists == false){
        header("location: ../html/login.php?error=loginError");
        exit();
    }

    if($pwd == $userExists["pwd"]){
        session_start();
        $_SESSION["uID"] = $userExists["uID"];
        header("location: ../html/index.php");
        exit();
    }
    else{
        header("location: ../html/login.php?error=loginError");
        exit();
    }
}

//Insert user into DB
function insertUser($conn, $fname, $lname, $email, $pwd){
    if(empty($fname and $lname and $email and $pwd)){
        header("location: ../html/signup.php?error=signupError");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("location: ../html/signup.php?error=invalidEmail");
        exit();
    }

    $userExists = userExist($conn, $email);
    if($userExists !== false){
        header("location: ../html/signup.php?error=userExist");
        exit();
    }
    $sql = "INSERT INTO users (firstName, lastName, email, pwd) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $email, $pwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../html/login.php");
    exit();
}

//Check if statement is valid
function validateStmt($stmt, $sql){
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../html/login.php?error=stmtFailed");
        exit();
    }
}

?>