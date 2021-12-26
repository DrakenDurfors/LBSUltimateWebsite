<?php 
function cardClub($cID, $conn){
    $sql = "SELECT * FROM clubs WHERE cID = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../html/index.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cID);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        $cName = $row['clubName'];
        $cDesc = $row['clubDescription'];

        if(strlen($cDesc)>200){
            $cDesc = substr($cDesc,0,200) . '...';
        }
        
        echo'
        <div class="card">
            <a href="#">
                <img src="../images/DSC_6017LBS Stockholm Södra helt oredigerat mindre upplösning_.jpg" alt="Avatar">
                <div class="container">
                    <h2 class="VIOLETT_TXT"><b>'.$cName.' ></b></h2> 
                    <p>'.$cDesc.'</p>
                    <br>
                    <hr>
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