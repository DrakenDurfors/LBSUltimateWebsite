<?php
session_start();
include_once 'connectToDB.inc.php';
include_once 'clubSearchFunctions.inc.php';
if (isset($_POST['pass'])) {
    switch ($_POST['pass']) {
        case "create";
            createClub($conn);
            break;
        case "remove";
            removeClub($conn);
            break;
        case "join";
            joinClub($conn);
            break;
        case "leave";
            leaveClub($conn);
        case "change":
            editClub($conn);
            break;
            break;
        case "leader";
            changeClubLeader($conn);
            break;
        case "editImg";
            editClubImg($conn);
            break;
        case "addActive";
            addActiveDay($conn);
            break;
        case "removeActive";
            removeActiveDay($conn);
            break;
        case "confirm";
            authorize($conn);
            break;
        default:
            header("Location:../");
            break;
    }
} else {
    header("Location:../");
}


function createClub($conn)
{
    /********************************************************************
    This function will create a club with a given name and description,
    then it will assign the creator as a club leader 
    -- this function is lacking image implementation
     ********************************************************************/
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $uID = $_SESSION['uID'];

    $sql = "INSERT INTO clubs (clubName, clubDescription, clubImage) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }
    //uppload image
    $allowed = array("jpg", "jpeg", "png");
    $dir = '../../img/';

    if (!!$_FILES['image']['tmp_name']) {
        $info = explode('.', strtolower($_FILES['image']['name']));
        if (in_array(end($info), $allowed)) {
            $_FILES['image']['name'] = str_replace(' ', '-', $_FILES['image']['name']);
            $_FILES['image']['name'] = preg_replace('/[^A-Za-z0-9\.-]/', '', $_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . basename($_FILES['image']['name']))) {
                $filePath = basename($_FILES['image']['name']);
            }
        } else {
            header("Location:../createClub.php?error=wrongFileType");
            exit();
        }
    } else {
        header("Location:../createClub.php?error=noImage");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $desc, $filePath);
    mysqli_stmt_execute($stmt);
    $cID = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    $sqlJoin = "INSERT INTO clubmembers (uID, cID) VALUES (?,?)";

    $stmtJoin = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmtJoin, $sqlJoin)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmtJoin, "ii", $uID, $cID);
    mysqli_stmt_execute($stmtJoin);
    mysqli_stmt_close($stmtJoin);

    $sqlLeader = "UPDATE clubmembers SET leader='1' WHERE uID=? AND cID=?";
    $stmtLeader = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmtLeader, $sqlLeader)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmtLeader, "ii", $uID, $cID);
    mysqli_stmt_execute($stmtLeader);
    mysqli_stmt_close($stmtLeader);

    header("Location:../createClub.php?success=clubCreated");
    exit();
}
function joinClub($conn)
{
    $cID = $_POST['cID'];
    $uID = $_SESSION['uID'];
    $sql = "INSERT INTO clubmembers (uID, cID) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../clubPage.php?c=" . $cID . "&error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $uID, $cID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../clubPage.php?c=" . $cID . "&success=join");
    exit();
}
function leaveClub($conn)
{
    $cID = $_POST['cID'];
    $uID = $_SESSION['uID'];
    $sql = "DELETE FROM clubmembers WHERE uID=? AND cID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../clubPage.php?c=" . $cID . "&error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $uID, $cID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../clubPage.php?c=" . $cID . "&success=leave");
    exit();
}

function editClub($conn)
{
    $cID = $_POST['cID'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    $leader = isClubLeader($conn, $_SESSION['uID'], $cID);
    if ($leader == 0) {
        header("Location:../clubs.php");
        exit();
    } else {

        $sql = "UPDATE clubs SET clubName=?, clubDescription=? WHERE cID=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../clubs.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssi", $name, $desc, $cID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../clubPage.php?c=" . $cID . "&success=edit");
        exit();
    }
}

function changeClubLeader($conn)
{
    $cID = $_POST['cID'];
    $uID = $_POST['uID'];
    $sql = "UPDATE clubmembers SET leader=CASE
    WHEN leader='0' THEN '1'
    WHEN leader='1' THEN '0'
    END WHERE uID=? AND cID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $uID, $cID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../?success=leader");
    exit();
}

function editClubImg($conn)
{
    //insert security protocols here (according to cID)
    $cID = $_POST['cID'];
    $leader = isClubLeader($conn, $_SESSION['uID'], $cID);
    if ($leader == 0) {
        header("Location:../clubs.php");
        exit();
    } else {
        //upload new image
        $allowed = array("jpg", "jpeg", "png");
        $dir = '../../img/';

        $row = findClubInfo($conn, $cID);
        $oldImg = $dir . $row['clubImage'];

        if (!!$_FILES['image']['tmp_name']) {
            $info = explode('.', strtolower($_FILES['image']['name']));
            if (in_array(end($info), $allowed)) {
                $_FILES['image']['name'] = str_replace(' ', '-', $_FILES['image']['name']);
                $_FILES['image']['name'] = preg_replace('/[^A-Za-z0-9\.-]/', '', $_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . basename($_FILES['image']['name']))) {
                    $filePath = basename($_FILES['image']['name']);
                    if ($row['clubImage'] != "def_Img.jpg") {
                        if (!unlink($oldImg)) {
                            //error handler?
                        } else {
                            //success!
                        }
                    }
                }
            } else {
                header("Location:../createClub.php?error=wrongFileType");
                exit();
            }
        } else {
            header("Location:../createClub.php?error=noImage");
            exit();
        }

        //insert new filepath int database:
        $sql = 'UPDATE clubs SET clubImage=? WHERE cID=?';
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../clubs.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "si", $filePath, $cID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../clubPage.php?c=" . $cID . "&success=leader");
        exit();
    }
}
function addActiveDay($conn)
{
    $clubb = $_POST['cID'];
    $time = $_POST['time'];
    if ($_POST['day'] >= 0 && $_POST['day'] <= 4) {
        $days = array("Måndag", "Tisdag", "onsdag", "tisdag", "fredag");
        $day = $days[$_POST['day']];
    } else {
        header("Location:../?error=invalidDay");
        exit();
    }


    $sql = "INSERT INTO active (cID, day, start) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iss", $clubb, $day, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['cID'] = $_POST['cID'];
    header("Location:../editClubPage.php?success=addDay");
    exit();
}
function removeActiveDay($conn)
{
    $dID = $_POST['dID'];
    $sql = "DELETE FROM active WHERE dID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $dID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['cID'] = $_POST['cID'];
    header("Location:../editClubPage.php?success=removeDay");
    exit();
}
function authorize($conn)
{
    $club = $_POST['cID'];
    if (isset($_SESSION['admin'])) {
        $sql = "UPDATE clubs SET authorized=CASE
        WHEN authorized='0' THEN '1'
        WHEN authorized='1' THEN '0'
        END WHERE cID=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../clubPage.php?c=" . $club . "&error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $club);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:../clubPage.php?c=" . $club . "&success=authorize");
        exit();
    } else {
        header("Location:../clubPage.php?c=" . $club . "&error=noAdmin");
    }
}
function removeClub($conn)
{
    $cID = $_POST['cID'];
    $sql = "SELECT COUNT(uID) as mark FROM clubmembers WHERE uID=? AND cID=? AND leader=1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../createClub.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $_SESSION['uID'], $cID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $leader = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);


    if ($leader['mark'] == 1 || isset($_SESSION['admin'])) {
        $sqlDelete = "DELETE FROM clubs WHERE cID=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sqlDelete)) {
            header("location: ../createClub.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $cID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:../?success=delete");
        exit();
    } else {
        header("Location:../?error=invalidUser");
        exit();
    }
}
