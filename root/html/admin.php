<?php 
//administrator page
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/errorHandler.inc.php";
require_once "includes/profileFunctions.inc.php";
require_once "includes/searchDB.inc.php";

session_start();
if(!isset($_SESSION['uID'])){
    header("location: ../html/index.php?error=notLogged");
    exit();
}

if(isset($_GET['s']) && $_GET['s'] != ''){
    $query = strval(trim($_GET['s']));

    searchUsers($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Hantera profiler</h1>
        <div class="wrapper">
            <form method="GET" action="">
                <table>
                    <tr>
                        <td><input type="text" name="s" placeholder="Search for a user"></td>
                        <td><input type="submit" name="" value="Search"></td>
                    </tr>
                </table>
            </form>
        </div>
    <h1>Hantera klubbar</h1>
</body>
</html>