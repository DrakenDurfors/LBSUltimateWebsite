<?php 
function cardEvent($eID, $conn){
    $sql = "SELECT * FROM schedule WHERE eID = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../html/index.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $eID);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        $eName = $row['eventName'];
        $eDesc = $row['eventDescription']; 
        $eDate = $row['eventDate'];

        if(strlen($eDesc)>50){
            $eDesc = substr($eDesc,0,50) . '...';
        }

        echo'
        <div class="event VIT">
            <a href="#">
                <div class="container">
                    <h4><b>'.$eName.'</b></h4> 
                    <p>'.$eDate.'</p>
                    <p>'.$eDesc.'</p> 
                </div>
                <div class="container">
                    <p>67 Registrerade</p>
                    <p class="ROSA_TXT"><b> SE EVENT ></b></p>
                </div>
            </a>
        </div>';
        mysqli_stmt_close($stmt);
    }
    else{
        mysqli_stmt_close($stmt);
    }
}
?>