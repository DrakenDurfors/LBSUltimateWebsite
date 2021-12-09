<?php
function searchUsers($conn, $query){
    $sql = "SELECT * FROM users WHERE ";
    $display_words = "";

    $keywords = explode(' ', $query);
    foreach($keywords as $word){
        $sql .= " keywords LIKE '%".$word."%' OR";
        $display_words .= $word." ";
    }

    $sql = substr($sql, 0, strlen($sql) - 3);

    $query_string = mysqli_query($conn, $sql);

    $result = mysqli_num_rows($query_string);

    if($result > 0){

    }
    else{

    }
}

?>