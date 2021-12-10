<?php
//functions page

//Check if user exists in DB -----------------------------------------------------------------------------------
function userExist($conn, $email, $uID){
    $sql = "SELECT * FROM users WHERE email = ? OR uID=?";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $email, $uID);
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

//login user ----------------------------------------------------------------------------------------------------
function loginUser($conn, $email, $pwd){
    $userExists = userExist($conn, $email, $email);
    
    if($userExists == false){
        header("location: ../html/login.php?error=loginError");
        exit();
    }

    $hPwd = hash("sha256",$pwd);

    if($hPwd == $userExists["pwd"]){
        session_start();
        if($userExists['admin'] == 1){
            $_SESSION["admin"] = $userExists["admin"];
        }
        $_SESSION["uID"] = $userExists["uID"];
        $_SESSION["firstName"] = $userExists["firstName"];
        $_SESSION["lastName"] = $userExists["lastName"];
        $_SESSION["email"] = $userExists["email"];
        header("location: ../html/index.php");
        exit();
    }
    else{
        header("location: ../html/login.php?error=loginError");
        exit();
    }
}

//Insert user into DB ---------------------------------------------------------------------------------------------
function insertUser($conn, $fname, $lname, $email, $pwd){
    if(empty($fname and $lname and $email and $pwd)){
        header("location: ../html/signup.php?error=fieldError");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("location: ../html/signup.php?error=invalidEmail");
        exit();
    }

    $userExists = userExist($conn, $email, $email);
    if($userExists !== false){
        header("location: ../html/signup.php?error=userExist");
        exit();
    }

    $hPwd = hash("sha256",$pwd);
    $sql = "INSERT INTO users (firstName, lastName, email, pwd) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $email, $hPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../html/login.php");
    exit();
}

//Change name ------------------------------------------------------------------------------------------------------
function changeName($conn, $nFName, $nLName, $uID){
    if(empty($nFName and $nLName)){
        header("location: ../html/profile.php?error=fieldError");
        exit();
    }

    validateUser(userExist($conn, $uID, $uID));

    $sql = "UPDATE users SET firstName=?, lastName=? WHERE uID = $uID";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $nFName, $nLName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../html/profile.php?success=changeName");
    exit();
}

//Change email ------------------------------------------------------------------------------------------------------
function changeEmail($conn, $nEmail, $uID){
    if(empty($nEmail)){
        header("location: ../html/profile.php?error=fieldError");
        exit();
    }
    if(!filter_var($nEmail, FILTER_VALIDATE_EMAIL)){
        header("location: ../html/profile.php?error=invalidEmail");
        exit();
    }

    $email = $_SESSION['email'];
    $userExists = userExist($conn, $email, $email);
    $checkNew = userExist($conn, $nEmail, $nEmail);
    if ($userExists == false){
        logout();
        exit();
    }
    else if($checkNew != false){
        header("location: ../html/profile.php?error=userExist");
        exit();
    }

    $sql = "UPDATE users SET email=? WHERE uID = $uID";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../html/profile.php?success=changeEmail");
    exit();
}

//Change password -----------------------------------------------------------------------------------------------------
function changePwd($conn, $pwd, $nPwd, $cNPwd, $uID){
    if(empty($pwd and $nPwd and $cNPwd)){
        header("location: ../html/profile.php?error=fieldError");
        exit();
    }

    $hPwd = hash("sha256",$pwd);
    $hNPwd = hash("sha256",$nPwd);
    $hCNPwd = hash("sha256",$cNPwd);

    $userExists = userExist($conn, $uID, $uID);

    validateUser($userExists);

    $oldPwd = $userExists['pwd'];

    if($hPwd != $oldPwd){
        header("location: ../html/profile.php?error=unmatchingPwd");
        exit();
    }
    else if($hNPwd != $hCNPwd){
        header("location: ../html/profile.php?error=confirmErr");
        exit();
    }
    else if($hPwd == $hNPwd){
        header("location: ../html/profile.php?error=samePwd");
        exit();
    }

    $sql = "UPDATE users SET pwd=? WHERE uID = $uID";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $hNPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../html/profile.php?success=changePwd");
    exit();
}

//delete user from db -------------------------------------------------------------------------------------------------
function deleteUser($conn, $uID, $pwd, $cPwd){
    if(empty($pwd and $cPwd)){
        header("location: ../html/profile.php?error=fieldError");
        exit();
    }

    $hPwd = hash("sha256",$pwd);
    $hCPwd = hash("sha256",$cPwd);

    $userExists = userExist($conn, $uID, $uID);
    validateUser($userExists);

    $dbPwd = $userExists['pwd'];

    if($hPwd != $hCPwd){
        header("location: ../html/profile.php?error=confirmErr");
        exit();
    }
    else if($hPwd != $dbPwd){
        header("location: ../html/profile.php?error=unmatchingPwd");
        exit();
    }

    $sql = "DELETE FROM users WHERE uID=$uID";
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_unset();
    session_destroy();
    header("location: ../html/index.php?success=deleteUser");
    exit();
}

//logout -------------------------------------------------------------------------------------------------------------
function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("location: ../html/index.php?success=logout");
    exit();
}

//Check if statement is valid -----------------------------------------------------------------------------------------
function validateStmt($stmt, $sql){
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../html/index.php?error=stmtFailed");
        exit();
    }
}

//Validates users existence in database --------------------------------------------------------------------------------
function validateUser($userExists){
    if ($userExists == false){
        logout();
        exit();
    }
}
?>