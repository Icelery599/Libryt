<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] !== "admin"){
    header("Location: ../dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="layout">
        <nav class="admin-navbar">
            <h2>Admin Sidebar</h2>
            <a href="../profile.php">Profile</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="add_book.php">Add Books</a>
            <a href="view_books.php">View Books</a>
            <a href="add_musuems.php">Add Artwork</a>
            <a href="view_museum.php">Manage Artworks</a>
            <a href="../logout.php">Logout</a>
        </nav>

        <main class="content admin-main-empty">
            <h1 class="admin-welcome">Welcome to the admin dashboard</h1>
        </main>
    </div>
    <footer class="site-footer">
        <div class="footer-wrap">
            <span>Lekiri Books &copy; All rights reserved 2026</span>
        </div>
    </footer>
</body>
</html>
