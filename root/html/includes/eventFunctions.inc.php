<?php
//todo: add check for arrival
include_once 'connectToDB.php';
if (isset($_POST['pass'])) {
    switch ($_POST['pass']) {
        case "create";
            createEvent($conn);
            break;
        case "edit":
            editEvent($conn);
            break;
        case "delete":
            removeEvent($conn);
            break;
        case "join":
            signup($conn);
            break;
        case "leave":
            signoff($conn);
            break;
        case "confirm":
            confirm($conn);
            break;
    }
}


function createEvent($conn)
{
    $name = $_POST['eventName'];
    $desc = $_POST['eventDesc'];
    $date = $_POST['eventDate'];
    $host = $_POST['clubb'];

    $sql = "INSERT INTO schedule (eventName, eventDescription, eventDate, eventHost) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../eventstuffs.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssi", $name, $desc, $date, $host);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../eventstuffs.php?success=createEvent");
    exit();
}



function editEvent($conn)
{
    $name = $_POST['newEventName'];
    $desc = $_POST['newEventDesc'];
    $date = $_POST['newEventDate'];
    $eID = $_POST['eID'];

    $sql = "UPDATE schedule SET eventName=?, eventDescription=?, eventDate=? WHERE eID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../eventstuffs.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssi", $name, $desc, $date, $eID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../eventstuffs.php?success=changeEvent");
    exit();
}

function removeEvent($conn)
{
    $event = $_POST['eID'];
    $sql = "DELETE FROM schedule WHERE eID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../eventstuffs.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $event);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../eventstuffs.php?success=removeEvent");
    exit();
}


function signup($conn)
{
    $event = $_POST['eID'];
    $sql = "INSERT INTO eventsignup (eID, uID) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../eventstuffs.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $event, $_SESSION['uID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../eventstuffs.php?success=join");
    exit();
}

function signoff($conn)
{
    $event = $_POST['eID'];
    $sql = "DELETE FROM eventsignup WHERE eID=? AND uID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../eventstuffs.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $event, $_SESSION['uID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../eventstuffs.php?success=signoff");
    exit();
}

function confirm($conn)
{
    $eID = $_POST['eID'];
    $uID = $_POST['uID'];
    // This sql functions like an if-statement (if 0 then 1, if 1 then 0)
    $sql = "UPDATE eventsignup 
    SET confirmed= CASE
    WHEN confirmed='0' THEN '1'
    WHEN confirmed='1' THEN '0'
    END
    WHERE eID = ? AND uID = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../eventstuffs.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $eID, $uID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../eventstuffs.php?action=show&eID=" . $eID . "#list");
}
