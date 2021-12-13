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

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<tr><td>Users found</tr></td>';
        while($rows = mysqli_fetch_assoc($result)){
            echo '<tr>
                <td><hr>'.$rows['firstName'].'</td>
                <td><hr>'.$rows['lastName'].'</td>
                <td><hr>'.$rows['email'].'</td>
                <td><hr><input type="submit" value="Select"></td>
                </tr>';
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