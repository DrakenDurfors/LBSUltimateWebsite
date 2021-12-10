<?php
function searchUsers($conn, $query){
    //Initiantes SQL statement
    $sql = "SELECT * FROM users WHERE ";

    //Updates SQL statement
    $keywords = explode(' ', $query);
    foreach($keywords as $word){
        $word = strval($word);
        $sql .= "email LIKE '%".$word."%' OR";
    }
    $sql = substr($sql, 0, strlen($sql) - 3);

    echo $sql;

    //Execute SQL code
    $stmt = mysqli_stmt_init($conn);
    validateStmt($stmt, $sql);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    //Prints results
    if($rows = mysqli_fetch_assoc($result)){
        echo '<tr><td>Users found</tr></td>';
        while($rows = mysqli_fetch_assoc($result)){
            echo '<tr>
                <td>'.$rows['firstName'].'</td>
                <td>'.$rows['lastName'].'</td>
                <td>'.$rows['email'].'</td>
            </tr>';
        }
        mysqli_stmt_close($stmt);
    }
    else{
        echo "<tr><td>Users not found</tr></td>";
        mysqli_stmt_close($stmt);
    }
}
?>