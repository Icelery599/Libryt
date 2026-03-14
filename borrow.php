<?php 
session_start();
include "db.php";

$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;

if(isset($_SESSION['user_id'])){
    $user_id = (int)$_SESSION['user_id'];
    if($_SESSION['role'] == "user"){
        if($book_id <= 0){
            echo "Invalid book selected! <a href='dashboard.php'>Go back</a>";
            exit();
        }

        $sql = "INSERT INTO transactions(user_id, book_id, issue_date, status)
                VALUES('$user_id', '$book_id', CURDATE(), 'borrowed')";
        $result = mysqli_query($conn, $sql);

        if($result){
            $sql2 = "UPDATE books SET quantity = quantity-1 WHERE id = '$book_id' AND quantity > 0";
            mysqli_query($conn, $sql2);
            header("Location: dashboard.php#available-books");
            exit();
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
