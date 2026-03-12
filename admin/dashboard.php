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
        :root{--bg:rgba(0,0,24,.967);--panel:rgba(120,120,248,.9);--txt:#fff;--accent:#fff312}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--txt);min-height:100vh}
        .layout{display:flex;min-height:100vh}
        .admin-navbar{width:290px;background:var(--panel);padding:24px 16px;display:flex;flex-direction:column}
        .admin-navbar h2{margin-bottom:18px}
        .admin-navbar a{display:block;color:var(--txt);text-decoration:none;background:rgba(0,0,0,.2);padding:12px;border-radius:8px;margin-bottom:10px}
        .admin-navbar a:hover{background:var(--accent);color:var(--bg)}
        .admin-navbar .copyright{margin-top:auto;font-size:.9rem;padding-top:10px}
        .content{flex:1;padding:28px;background:rgba(120,120,248,.15)}
        .workspace{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-top:14px}
        .panel{background:var(--panel);padding:18px;border-radius:10px;min-height:200px}
        .panel h3{margin-bottom:10px}
        .placeholder{border:2px dashed rgba(255,255,255,.55);padding:22px;border-radius:8px;text-align:center;line-height:1.5}
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
