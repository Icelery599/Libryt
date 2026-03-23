<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
if($_SESSION['role'] !== 'admin'){
    header("Location: ../dashboard.php");
    exit();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($id > 0){
    $stmt = $conn->prepare("DELETE FROM artworks WHERE id = ?");
    if($stmt){
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: view_museum.php");
exit();
