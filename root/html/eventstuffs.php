<?php
// if(!isset($_SESSION["userId"])){
//     header("Location:./?error=notLogged");
// }
require_once "includes/connectToDB.inc.php";
// Temporary session variable for testing purpouses:
$_SESSION['uID'] = 1;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Document</title>
</head>

<body>
    <div class="schedule">
        <h1>Upcomming events</h1>
        <div class="eventContainer">
            <?php
            $today = date("Y-m-d", strtotime('-5 days'));
            $sql = "SELECT schedule.eID, schedule.eventName, schedule.eventDescription, schedule.eventDate, clubs.clubName
                FROM schedule INNER JOIN clubs WHERE schedule.eventHost = clubs.cID AND schedule.eventDate > '" . $today . "' ORDER BY schedule.eventDate;";
            $query = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                $sql = "SELECT COUNT(*) FROM eventSignup WHERE uID='" . $_SESSION['uID'] . "' AND eID='" . $row[0] . "'";
                $result = mysqli_query($conn, $sql);
                $hasJoined = mysqli_fetch_array($result);
                if ($hasJoined[0] === "1") {
                    $pass = "leave";
                } else {
                    $pass = "join";
                }
                //the hidden input 'action' will be removed when it links to participants page
                echo '
                <div>
                <h3>' . $row[1] . '</h3>
                <p>' . $row[2] . '</p>
                <p>Date:' . $row[3] . '</p>
                <p>Host:' . $row[4] . '</p>
                <form action="includes/eventFunctions.inc.php" method="post">
                    <input type="hidden" name="pass" value="' . $pass . '">
                    <input type="hidden" name="eID" value="' . $row[0] . '">
                    <input type="submit" value="' . $pass . '">
                </form>
                <form action="" method="get">
                    <input type="hidden" name="action" value="show">
                    <input type="hidden" name="eID" value="' . $row[0] . '">
                    <input type="submit" value="Show Participants">
                </form>
                </div>
                ';
            }

            ?>
        </div>
    </div>

    <?php
    if (isset($_GET['action']) && $_GET['action'] == "show") {
        $eID = $_GET['eID'];
        echo '<div class="attendees" id="list">
        <table>';
        $sql = "SELECT users.uID, CONCAT(users.firstName, ' ', users.lastName), eventsignup.confirmed
                FROM eventsignup INNER JOIN users 
                WHERE eventsignup.eID = ? AND eventsignup.uID = users.uID 
                ORDER BY users.firstName ASC;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../eventstuffs.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $eID);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_array($query)) {
            echo '
                <tr>
                <td>' . $row[1] . '</td>
                <td>' . $row[2] . '</td>
                <td>
                <form action="includes/eventFunctions.inc.php" method="post">
                <input type="hidden" name="uID" value="' . $row[0] . '">
                <input type="hidden" name="eID" value="' . $eID . '">
                <input type="hidden" name="pass" value="confirm">
                <input type="submit" value="O">
                </form>
                </td>
                </tr>
            ';
        }
        mysqli_stmt_close($stmt);
        echo '</table>
        </div>';
    }
    ?>



    <form action="includes/eventFunctions.inc.php" method="post">
        <div>
            <input type="text" name="eventName" required>
        </div>
        <div>
            <input type="text" name="eventDesc" required>
        </div>
        <div>
            <input type="date" name="eventDate" required>
        </div>
        <div>
            <!--Add clubb detection (post from klubbsida):-->
            <input type="hidden" name="clubb" value="1">
            <input type="hidden" name="pass" value="create">
            <input type="submit" value="create Event">
        </div>

    </form>

    <form action="includes/eventFunctions.inc.php" method="post">
        <div>
            <input type="text" name="newEventName" required>
        </div>
        <div>
            <input type="text" name="newEventDesc" required>
        </div>
        <div>
            <input type="date" name="newEventDate" required>
        </div>
        <div>
            <!--Add event detection-->
            <input type="hidden" name="eID" value="2">
            <input type="hidden" name="pass" value="edit">
            <input type="submit" value="change event">
        </div>
    </form>
</body>

</html>