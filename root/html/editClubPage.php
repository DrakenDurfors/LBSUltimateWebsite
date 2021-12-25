<?php
session_start();
require "includes/connectToDB.inc.php";
require "includes/clubSearchFunctions.inc.php";
if (!isset($_SESSION['uID'])) {
    header("location: ../html/index.php?error=notLogged");
    exit();
}
if (isset($_POST['cID'])) {
    $_SESSION['cID'] = $_POST['cID'];
    header("Location:editClubPage.php");
    exit();
}
//find the club information
$info = findClubInfo($conn, $_SESSION['cID']);

//find active days
$resultA = findActiveDays($conn, $_SESSION['cID']);

//find relevant user info
$rowC = isClubLeader($conn, $_SESSION['uID'], $_SESSION['cID']);

if (is_null($rowC) || $rowC == 0 || is_null($info) || !isset($_SESSION['cID'])) {
    header("Location:./clubs.php");
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
    <div>
        <form action="includes/clubFunctions.inc.php" method="post">
            <h1>Edit: </h1>
            <input type="text" name="name" id="" value=<?php echo $info['clubName'] ?> required>
            <input type="text" name="desc" id="" value="<?php echo $info['clubDescription'] ?>" required>
            <input type="hidden" name="cID" value=<?php echo '"' . $_SESSION['cID'] . '"'; ?>>
            <input type="hidden" name="pass" value="change">
            <input type="submit" value="Confirm change">
        </form>
        <hr>
        <form action="includes/clubFunctions.inc.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pass" value="editImg">
            <input type="hidden" name="cID" value=<?php echo '"' . $_SESSION['cID'] . '"'; ?>>
            <input type="file" name="image" id="">
            <input type="submit" value="Change image">
        </form>
        <hr>
        <table>
            <?php
            while ($row = mysqli_fetch_assoc($resultA)) {
                echo '
                    <tr>
                    <td>' . ucfirst($row['day']) . '</td>
                    <td>' . date("H:i", strtotime($row["start"])) . '</td>
                    <td>
                    <form action="includes/clubFunctions.inc.php" method="post">
                    <input type="hidden" name="dID" value=' . $row['dID'] . '>
                    <input type="hidden" name="cID" value=' . $_SESSION['cID'] . '>
                    <input type="hidden" name="pass" value="removeActive">
                    <input type="submit" value="Delete">
                    </form>
                    </td>
                    </tr>
                    ';
            }
            ?>
        </table>
        <?php
        echo '
                <form action="includes/clubFunctions.inc.php" method="POST">
                <input type="hidden" name="cID" value=' . $_SESSION['cID'] . '>
                <input type="hidden" name="pass" value="addActive">
                <select name="day" required>
                    <option value="" disabled>-- Välj dag --</option>
                    <option value="0">Måndag</option>
                    <option value="1">Tisdag</option>
                    <option value="2">Onsdag</option>
                    <option value="3">Torsdag</option>
                    <option value="4">Fredag</option>
                </select>
                <input type="time" name="time" required>
                <input type="submit" value="Lägg till dag">
                </form>
            ';

        ?>

    </div>

</body>

</html>





<?php
unset($_SESSION['cID']);
