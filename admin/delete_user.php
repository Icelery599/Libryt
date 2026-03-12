<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: manage_users.php");
    exit();
}

if(isset($_GET['$user_id'])){

    $user_id = $_GET['user_id'];

    $sql = "DELETE FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Error: " . mysqli_error($conn));
    }

    header("Location: manage_users.php");
}
?>