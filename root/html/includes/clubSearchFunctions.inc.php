<?php
if (!isset($_SESSION['uID'])) {
    header("location: ../?error=notLogged");
    exit();
}

function findClubInfo($conn, $club)
{
    $sql = "SELECT clubName, clubDescription, clubImage, authorized, adminOnly FROM clubs WHERE cID=? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:./");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $club);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row;
}

function findActiveDays($conn, $club){
    $sqlA = "SELECT dID, day, start FROM active WHERE cID=?";
    $stmtA = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtA, $sqlA)) {
        header("Location:./");
        exit();
    }
    mysqli_stmt_bind_param($stmtA, "i", $club);
    mysqli_stmt_execute($stmtA);
    $resultA = mysqli_stmt_get_result($stmtA);
    mysqli_stmt_close($stmtA);
    return $resultA;
}

function isClubLeader($conn, $user, $cID){
    $sqlC = "SELECT leader FROM clubMembers WHERE cID=? AND uID=?";
    $stmtC = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtC, $sqlC)) {
        header("Location:./");
        exit();
    }
    mysqli_stmt_bind_param($stmtC, "ii", $cID, $user);
    mysqli_stmt_execute($stmtC);
    $resultC = mysqli_stmt_get_result($stmtC);
    $rowC = mysqli_fetch_assoc($resultC);
    mysqli_stmt_close($stmtC);
    return $rowC['leader'];
}
