<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] !== "user"){
    header("Location: admin/dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$transaction_id = isset($_GET['transaction_id']) ? (int)$_GET['transaction_id'] : 0;

if($transaction_id <= 0){
    header("Location: dashboard.php");
    exit();
}

$transactionQuery = "SELECT id FROM transactions WHERE id = ? AND user_id = ?";
$transactionStmt = mysqli_prepare($conn, $transactionQuery);
mysqli_stmt_bind_param($transactionStmt, "ii", $transaction_id, $user_id);
mysqli_stmt_execute($transactionStmt);
$transactionResult = mysqli_stmt_get_result($transactionStmt);
$transaction = mysqli_fetch_assoc($transactionResult);
mysqli_stmt_close($transactionStmt);

if(!$transaction){
    header("Location: dashboard.php");
    exit();
}

$today = date('Y-m-d');
$updateQuery = "UPDATE transactions SET status='returned', return_date=? WHERE id=? AND user_id=?";
$updateStmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($updateStmt, "sii", $today, $transaction_id, $user_id);
mysqli_stmt_execute($updateStmt);
mysqli_stmt_close($updateStmt);

header("Location: payment_gateway.php?transaction_id=" . urlencode($transaction_id));
exit();
