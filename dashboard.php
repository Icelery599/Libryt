<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] !== "user"){
    header("Location: admin/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:Arial, sans-serif;background:rgba(0,0,24,.967);color:#fff;min-height:100vh}
    .layout{display:flex;min-height:100vh}
    .sidebar{width:260px;background:rgba(120,120,248,.9);padding:24px 16px;display:flex;flex-direction:column}
    .sidebar h2{margin-bottom:16px}
    .sidebar a{display:block;color:#fff;text-decoration:none;background:rgba(0,0,0,.2);padding:12px;border-radius:8px;margin-bottom:10px}
    .sidebar a.logout{margin-top:auto;background:#c0392b}
    .content{flex:1;padding:28px}
    .adverts{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
    .advert{background:rgba(120,120,248,.9);padding:16px;border-radius:10px}
</style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <h2>User Dashboard</h2>
        <a href="profile.php">Profile (Update)</a>
        <a href="index.php">Borrow Books</a>
        <a href="view_museum.php">View Museum</a>
        <a class="logout" href="logout.php">Logout</a>
    </aside>

    <main class="content">
        <h1>Adverts</h1>
        <br>
        <section class="adverts">
            <article class="advert"><h3>New Arrival</h3><p>Explore newly added books and borrow today.</p></article>
            <article class="advert"><h3>Museum Week</h3><p>Visit the museum collection and discover local history.</p></article>
            <article class="advert"><h3>Reading Challenge</h3><p>Borrow 3 books this month and earn a recognition badge.</p></article>
        </section>
    </main>
</div>
</body>
</html>
