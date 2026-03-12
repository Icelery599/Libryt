<?php
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    if($_SESSION['role'] == "user"){
        echo "You are user";
    }else{
        header("Location: ../dashboard.php");
        exit();
    }
}else{
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Page</title>
</head>
<body>

<a href="requestcheck.php">Request Update</a>
<a href="logout.php">Log out</a>

</body>
</html>