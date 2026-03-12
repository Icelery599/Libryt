<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($password !== ""){
        $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$user_id'";
    }else{
        $sql = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    }

    $result = mysqli_query($conn, $sql);
    $message = $result ? "Profile updated successfully." : "Error updating profile: {$conn->error}";
}

$user_sql = "SELECT name, email, role FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);
$back_link = ($user['role'] === 'admin') ? 'admin/dashboard.php' : 'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:rgba(0,0,24,.967);color:#fff}
        .card{width:min(500px,92%);margin:70px auto;background:rgba(120,120,248,.9);padding:24px;border-radius:12px}
        input,button{width:100%;padding:12px;margin-top:10px;border:none;border-radius:8px}
        button{background:#fff312;cursor:pointer}
        a{display:inline-block;margin-top:14px;color:#fff}
        .message{margin-bottom:10px}
    </style>
</head>
<body>
<div class="card">
    <h1>Update Profile</h1>
    <?php if($message !== ""): ?><p class="message"><?php echo $message; ?></p><?php endif; ?>
    <form method="post" action="profile.php">
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <input type="password" name="password" placeholder="New password (optional)">
        <button type="submit">Save Changes</button>
    </form>
    <a href="<?php echo $back_link; ?>">Back to Dashboard</a>
</div>
</body>
</html>
