<?php
session_start();
require "includes/connectToDB.inc.php";
require "includes/clubSearchFunctions.inc.php";
if (!isset($_SESSION['uID'])) {
    header("location: ../html/index.php?error=notLogged");
    exit();
}
//find the club information
$row = findClubInfo($conn, $_GET['c']);

//find active days
$resultA = findActiveDays($conn, $_GET['c']);

//find relevant user info
$rowC = isClubLeader($conn, $_SESSION['uID'], $_GET['c']);


if (($row['authorized'] == 0 && !isset($_SESSION['admin'])) || is_null($row)) {
    header("Location:./");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club</title>
</head>

<body>
    <div>
        <h1><?php echo $row['clubName']; ?></h1>
        <p><?php
            while ($rowA = mysqli_fetch_assoc($resultA)) {
                echo ' ' . $rowA['day'] . ': ' . date("H:i", strToTime($rowA['start']));
            }
            ?></p>
        <p><?php echo $row['clubDescription']; ?></p>
        <img src="" alt="">
        <?php
        if (!is_null($rowC)) {
        ?>
            <form action="includes/clubFunctions.inc.php" method="post">
                <input type="hidden" name="pass" value="leave">
                <input type="hidden" name="cID" value=<?php echo $_GET['c']; ?>>
                <input type="submit" value="Leave clubb">
            </form>
        <?php
        } else {
        ?>
            <form action="includes/clubFunctions.inc.php" method="post">
                <input type="hidden" name="pass" value="join">
                <input type="hidden" name="cID" value=<?php echo $_GET['c']; ?>>
                <input type="submit" value="Join clubb">
            </form>
        <?php
        }
        if ($row['authorized'] == 0 && isset($_SESSION['admin'])) {
        ?>
            <form action="includes/clubFunctions.inc.php" method="post">
                <input type="hidden" name="pass" value="confirm">
                <input type="hidden" name="cID" value="<?php echo $_GET['c']; ?>">
                <input type="submit" value="Authorize clubb">
            </form>
            <?php
        }
        if (!is_null($rowC)) {
            if ($rowC == 1 || isset($_SESSION['admin'])) {
                //assign leader
                //Use erics search function <-- help needed
            }
            if ($rowC == 1) {
            ?>
                <div>
                    <form action="editClubPage.php" method="post">
                        <input type="hidden" name="cID" value=<?php echo $_GET['c'] ?>>
                        <input type="submit" value="Edit club" name="edit">
                    </form>
                </div>
                <div>
                    <form action="eventEdit.php" method="post">
                        <input type="hidden" name="cID" value=<?php echo $_GET['c'] ?>>
                        <input type="submit" value="Create event" name="event">
                    </form>
                </div>

        <?php
            }
        }
        ?>
    </div>
</body>

</html>