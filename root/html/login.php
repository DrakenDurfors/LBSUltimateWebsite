<?php
// Include connect file
require_once "includes/connectToDB.php";

if(isset($_POST['txt_uname'])){
    $uname =$_POST['txt_uname'];
    $passw =$_POST['txt_pwd'];

    $sql="SELECT * from login where name='".$uname."'AND password='".$passw."' limit 1";

    $result= $conn->query($sql);

    if(mysqli_num_rows($result)==1){
        echo "logged in";
    }
    else {
        echo "you failed to log in";
    }
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
<div class="container">
    <form method="post" action="#">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" name="txt_uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" name="txt_pwd" placeholder="Password"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>
</body>
</html>