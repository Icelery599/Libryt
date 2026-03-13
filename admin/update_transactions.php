<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: ../view_transactions.php");
    exit();
}

$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : 0;

if(isset($_POST['submit'])){
    $returndate = $_POST['returndate'];
    $status = $_POST['status'];

    $sql = "UPDATE transactions 
            SET return_date='$returndate', status='$status' 
            WHERE id='$transaction_id'";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Error: " . mysqli_error($conn));
    }

    echo "Transaction updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <form action="update_transactions.php?transaction_id=<?php echo $transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : 0; ?>" method="post">
    <input type="text" name="returndate" required placeholder="date-format: 2026-03-09">
    <select name="status" id="">
        <option value="borrowed">Borrowed</option>
        <option value="returned">Returned</option>
    </select>
    <input type="submit" name="submit" value="update">
    </form>
</body>
</html>