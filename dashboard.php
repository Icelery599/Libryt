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
    <link rel="stylesheet" href="/styles.css">
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
