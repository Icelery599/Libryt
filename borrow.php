<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== "user") {
    header("Location: admin/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['book_id'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = mysqli_real_escape_string($conn, $_POST['book_id']);

$checkBookSql = "SELECT id FROM books WHERE id = '$book_id' LIMIT 1";
$bookResult = mysqli_query($conn, $checkBookSql);

if (!$bookResult || mysqli_num_rows($bookResult) === 0) {
    echo "Selected book was not found. <a href='dashboard.php'>Go back</a>";
    exit();
}

$checkRequestSql = "SELECT id FROM transactions WHERE user_id = '$user_id' AND book_id = '$book_id' AND status IN ('pending', 'borrowed') LIMIT 1";
$existingRequest = mysqli_query($conn, $checkRequestSql);

if ($existingRequest && mysqli_num_rows($existingRequest) > 0) {
    echo "You already have an active request for this book. <a href='dashboard.php'>Go back</a>";
    exit();
}

$sql = "INSERT INTO transactions (user_id, book_id, issue_date, status)
        VALUES ('$user_id', '$book_id', CURDATE(), 'pending')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Your borrow request has been sent to the librarian! <a href='dashboard.php'>Go back</a>";
} else {
    echo "Error: {$conn->error}";
}
?>
