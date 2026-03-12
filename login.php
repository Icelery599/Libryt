
<?php
include "db.php";
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "select  * from users where 
    email = '$email'";
   $result =  mysqli_query($conn, $sql);
   if($result->num_rows>0){
    $row = mysqli_fetch_assoc($result);
    if($row['password'] == $password){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        if($row['role'] == "admin"){
           header("Location: admin/dashboard.php"); 
        }else{
            header("Location: dashboard.php");
        }
    }else{
        header("Location: login.php");
    }
   }else{
    echo "error!: {$result->error}";
   }
}
?>

<!DOCTYPE html>
<html>
<?php
include "heading.php";
?>
<body>
    <div class="register">
        <form action="login.php" method="post">
        <input type="email" name="email" placeholder="enter your email"><br>
        <input type="password" name="password" placeholder="enter your password" required><br>
        <button type="submit">Log in</button><br>
        <p>No yet registered? <a href="register.php">Sign up</a></p>
    </form>
    </div>
</body>
</html>