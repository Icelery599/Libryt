<?php
session_start();
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        echo "Welcome to the admin dashboard";
    }else{
        header("Location: ../dashboard.php");
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
    <title>Library</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0; 
        }
        body{
            background: rgba(0, 0, 24, 0.967);
            background-size: cover;
        }
        .admin-navbar{
            display: flex;
            width: 200px;
            flex-direction: column;
            background-color: green;
            color: white;
        }
        .admin-navbar ul li{
            list-style-type: none;
            margin: 20px;
        }
        .admin-navbar ul li a{
          color: white;
          text-decoration: none;
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <ul>
            <li><a href="view_transactions.php">View Transactions</a></li>
            <li><a href="manage_users.php">Manage users</a></li>
        </ul>
    </nav>
    <a href="../logout.php">Log out</a>
</body>
</html>