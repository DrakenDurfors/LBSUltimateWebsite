<?php
session_start();
if(!isset($_SESSION['uID'])){
    header("location: ../?error=notLogged");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="includes/clubFunctions.inc.php" method="post" enctype="multipart/form-data">
    <input type="text" name="name">
    <input type="text" name="description">
    <input type="file" name="image" id="image" required>
    <input type="hidden" name="pass" value="create">
    <input type="submit" value="Create" name="newClubSubmit">
    </form>
</body>
</html>