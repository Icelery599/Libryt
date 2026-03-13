<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit();
}


$sql = "SELECT * FROM transactions";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
        <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>user id</th>
                <th>book id</th>
                <th>issue date</th>
                <th>return date</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
           <?php
if(isset($result) && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['book_id']; ?></td>
    <td><?php echo $row['issue_date']; ?></td>
    <td><?php echo $row['return_date']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><a class="update" href="update_transactions.php?transaction_id=<?php echo $row['id']; ?>">Update</a></td>
    <td><a class="delete" href="delete_transactions.php?transaction_id=<?php echo $row['id']; ?>">Delete</a></td>
</tr>
<?php
    }
}
?>
        </tbody>
    </table>
</body>
</html>