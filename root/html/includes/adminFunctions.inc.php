<?php
function searchUsers($conn, $query){
    //Initiantes SQL statement
    $query = htmlspecialchars($query);

    $sql = "SELECT * FROM users WHERE ";

    //Updates SQL statement
    $keywords = explode(' ', $query);
    foreach($keywords as $word){
        $word = strval($word);
        $sql .= "email LIKE '%".$word."%' OR firstName LIKE '%".$word."%' OR lastName LIKE '%".$word."%' OR ";
    }
    $sql = substr($sql, 0, strlen($sql) - 3);

    //Gets results
    $result = mysqli_query($conn, $sql);

    //Prints results
    if(mysqli_num_rows($result) > 0){
        echo '<tr><td>Users found</tr></td>';
        while($rows = mysqli_fetch_assoc($result)){
            echo '<form method="GET" action=""><tr>
                <td><hr>'.$rows['firstName'].'</td>
                <td><hr>'.$rows['lastName'].'</td>
                <td><hr>'.$rows['email'].'</td>
                <td><hr><input type="hidden" name="Id" value="'.$rows['uID'].'"><input type="submit" value="Select"></td>
                </tr></form>';
        }
    }
    else{
        echo "<tr><td>Users not found</tr></td>";
    }
}

function selectUser(){
    echo "Congrats";
}
?>