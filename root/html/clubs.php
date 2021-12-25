<?php
session_start();
require "includes/connectToDB.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs</title>
</head>

<body>
    <div>
        <?php
        if (isset($_SESSION['admin'])) {
            $sql = "SELECT * FROM clubs WHERE adminOnly=0";
        } else {
            $sql = "SELECT * FROM clubs WHERE adminOnly=0 AND authorized=1";
        }

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div>
                <img src="../img/' . $row['clubImage'] . '" alt="" style="width:200px">
                <h1><a href="clubPage.php?c=' . $row['cID'] . '">' . $row['clubName'] . ' ></a></h1>
                <p>';

            $sqlActive = "SELECT day, start FROM active WHERE cID = " . $row['cID'] . "";
            $resultActive = mysqli_query($conn, $sqlActive);
            while ($activeRow = mysqli_fetch_assoc($resultActive)) {
                echo ' ' . ucfirst($activeRow["day"]) . ' ' . date("H:i", strtotime($activeRow["start"]));
            }

            echo '</p>
                <b>Detaljer:</b>
                <p>' . $row['clubDescription'] . '</p>
            </div>';
        }

        ?>
        <a href="createClub.php">Skapa en ny klubb!</a>
    </div>

</body>

</html>