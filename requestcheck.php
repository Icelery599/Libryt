<?php
session_start();
include "db.php";
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "user"){
        $user_id = $_SESSION['user_id'];
        $sql = "select * from transactions where user_id = '$user_id'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "error!: {$conn->error}";
        } 
   }
}else{
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
        <link rel="stylesheet" href="styles.css">
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
</tr>
<?php
    }
}else{
?>
<tr>
    <td colspan="5">No transactions found</td>
</tr>
<?php
}
?>
        </tbody>
    </table>
</body>
</html>