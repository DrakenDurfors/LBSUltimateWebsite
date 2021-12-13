<?php
if (isset($_POST('clubPass'))) {
    createClub();
} else {
    header("Location:../createClub.php");
}


function createClub()
{
    $name = $_POST['name'];
    $desc = $_POST['description'];
}
