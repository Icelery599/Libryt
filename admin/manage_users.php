<?php
session_start();
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        include "../db.php";
        $sql = "select id, name, email, role from users where role = 'user'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "error!: {$conn->error}";
        }
    }else{
        header("Location: ../dashboard.php");
    }
}else{
    header("Location: ../login.php");
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
        }.link{
            text-decoration: none;
            background: purple;
            color: white;
        }

    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           <?php
if(isset($result) && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['role']; ?></td>
    <td><a class="link" href="delete_user.php?user_id=<?php echo $row['id']; ?>">Delete users</a></td>
</tr>
<?php
    }
}
?>
        </tbody>
    </table>
</body>
</html>