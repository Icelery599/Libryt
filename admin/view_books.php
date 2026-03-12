<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit();
}

include "../db.php";

$sql = "SELECT * FROM books";
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
    <style>
        *{
            margin: 0;
            padding: 0; 
        }
        body{
            background: rgba(0, 0, 24, 0.967);
            background-size: cover;
        }
        table{
            border: none;
            width: 100%;
        }
        tr, th{
            border-bottom: 2px solid green;
        }
        td{
            background-color: green;
            border: none;
            text-align: center;
        }
        td img{
            width: 70px;
            height: 70px;
            border-radius: 2px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Image</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
           <?php
if(isset($result) && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['author']; ?></td>
    <td><?php echo $row['isbn']; ?></td>
    <td><img src="../image/<?php echo $row['image']; ?>" alt=""></td>
    <td><?php echo $row['quantity']; ?></td>
</tr>
<?php
    }
}
?>
        </tbody>
    </table>
</body>
</html>