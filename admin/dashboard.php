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
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:rgba(0,0,24,.967);color:#fff;min-height:100vh}
        .layout{display:flex;min-height:100vh}
        .admin-navbar{width:280px;background:rgba(46,204,113,.85);padding:24px 16px;display:flex;flex-direction:column}
        .admin-navbar h2{margin-bottom:18px}
        .admin-navbar a{display:block;color:#fff;text-decoration:none;background:rgba(0,0,0,.2);padding:12px;border-radius:8px;margin-bottom:10px}
        .admin-navbar a.logout{margin-top:auto;background:#c0392b}
        .content{flex:1;padding:28px}
        .adverts{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
        .advert{background:rgba(46,204,113,.75);padding:16px;border-radius:10px}
    </style>
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
            <a class="logout" href="../logout.php">Logout</a>
        </nav>

        <main class="content">
            <h1>Adverts</h1>
            <br>
            <section class="adverts">
                <article class="advert"><h3>Reminder</h3><p>Review overdue transactions this week.</p></article>
                <article class="advert"><h3>Catalog Update</h3><p>Add new book arrivals to keep inventory fresh.</p></article>
                <article class="advert"><h3>Museum Campaign</h3><p>Create a featured exhibit and publish museum highlights.</p></article>
            </section>
        </main>
    </div>
</body>
</html>
