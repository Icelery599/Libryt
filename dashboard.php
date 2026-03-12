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
    :root{--bg:rgba(0,0,24,.967);--panel:rgba(120,120,248,.9);--txt:#fff;--accent:#fff312}
    body{font-family:Arial,sans-serif;background:var(--bg);color:var(--txt);min-height:100vh}
    .layout{display:flex;min-height:100vh}
    .sidebar{width:280px;background:var(--panel);padding:24px 16px;display:flex;flex-direction:column}
    .sidebar h2{margin-bottom:16px}
    .sidebar a{display:block;color:var(--txt);text-decoration:none;background:rgba(0,0,0,.2);padding:12px;border-radius:8px;margin-bottom:10px}
    .sidebar a:hover{background:var(--accent);color:var(--bg)}
    .sidebar-footer{margin-top:auto;padding-top:16px;font-size:.9rem}
    .content{flex:1;padding:28px;background:rgba(120,120,248,.15)}
    .survey-box{max-width:700px;background:var(--panel);padding:20px;border-radius:10px}
    .survey-box h1{margin-bottom:12px}
    .survey-box p{line-height:1.6;margin-bottom:14px}
    .survey-box ul{padding-left:18px;line-height:1.7}
</style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <h2>User Dashboard</h2>
        <a href="index.php">Your Books</a>
        <a href="view_museum.php">See Museum</a>
        <a href="return.php">Pay for Overdue Books</a>
        <a href="logout.php">Logout</a>
        <div class="sidebar-footer">Copyright © 2026</div>
    </aside>

    <main class="content">
        <section class="survey-box">
            <h1>Book Recommendation Survey</h1>
            <p>Answer this survey to help us know the books we can recommend for you.</p>
            <ul>
                <li>What genres do you enjoy most?</li>
                <li>Do you prefer short reads or long novels?</li>
                <li>Are you interested in history, science, fiction, or biographies?</li>
                <li>How many books do you plan to read each month?</li>
            </ul>
        </section>
    </main>
</div>
</body>
</html>
