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
            <a href="add_musuems.php">Add Things in Museum</a>
            <a href="view_museum.php">View Museum</a>
            <a href="../logout.php">Logout</a>
            <div class="copyright">Copyright © 2026</div>
        </nav>

        <main class="content">
            <h1>Admin Dashboard Workspace</h1>
            <p>Use this area for displaying update and delete actions.</p>
            <section class="workspace">
                <article class="panel">
                    <h3>Update Space</h3>
                    <div class="placeholder">This panel is reserved for update forms and edited records.</div>
                </article>
                <article class="panel">
                    <h3>Delete Space</h3>
                    <div class="placeholder">This panel is reserved for delete confirmations and removed items log.</div>
                </article>
            </section>
        </main>
    </div>
</body>
</html>
