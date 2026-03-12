<?php 
session_start();
include "db.php";
if($_GET['book_id']){
    $book_id = $_GET['book_id'];
}
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    if($_SESSION['role'] == "user"){
        $sql = "insert into transactions(
        user_id, book_id, issue_date, status) values('$book_id', '$book_id', CURDATE(), 'borrowed')";
        $result = mysqli_query($conn, $sql);
        if($result){
            $sql2 = "update books set quantity = quantity-1 where id = '$book_id'";
            $result2 = mysqli_query($conn, $sql2);
            echo "Your request has been sent to the librarian!<a href='index.php'>go back</a>";
        }else{
            echo "error!: {$conn->error}";
        }
    }else{
        header("Location: admin/dashboard.php");
    }
}else{
    header("Location: login.php");
}

?> 