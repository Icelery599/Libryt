<?php
include "db.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "insert into users (name, email, password, role) values ('$name', '$email', '$password', '$role')";
   $result =  mysqli_query($conn, $sql);
   if(!$result){
    echo "Error ! : {$result->error}";
   }
   else{
    echo "you have registered successfully!";
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
        <form action="register.php" method="post">
        <input type="text" name="name" placeholder="enter your name"><br>
        <input type="email" name="email" placeholder="enter your email"><br>
        <input type="password" name="password" placeholder="enter your password" required><br>
        <input type="text" name="role" value="user" hidden><br>
        <button type="submit">Sign up</button><br>
    </form>
    </div>
</body>
</html>