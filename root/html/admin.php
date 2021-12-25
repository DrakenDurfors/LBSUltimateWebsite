<?php 
//administrator page
//Include files
require_once "includes/connectToDB.inc.php";
require_once "includes/errorHandler.inc.php";
require_once "includes/profileFunctions.inc.php";
require_once "includes/adminFunctions.inc.php";

session_start();
if(!isset($_SESSION['uID'])){
    header("location: ../html/index.php?error=notLogged");
    exit();
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
        <div>
            <form method="GET" action="">
                <table>
                    <tr>
                        <td><input type="text" name="sr" placeholder="Search for a user"></td>
                        <td><input type="submit" name="" value="Search"></td>
                    </tr>
                    <?php 
                    if(isset($_GET['sr']) && $_GET['sr'] != ''){
                        $query = trim($_GET['sr']);
                    
                        searchUsers($conn, $query);
                    }
                    ?>
                </table>
            </form>
        </div>
    <h1>Hantera klubbar</h1>
</body>
</html>