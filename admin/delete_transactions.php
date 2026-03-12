<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: view_transactions.php");
    exit();
}

if(isset($_GET['transaction_id'])){

    $transaction_id = $_GET['transaction_id'];

    $sql = "DELETE FROM transactions WHERE id='$transaction_id'";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Error: " . mysqli_error($conn));
    }

    header("Location: view_transactions.php");
}
?>