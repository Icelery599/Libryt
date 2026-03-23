<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
if($_SESSION['role'] !== 'user'){
    header("Location: admin/dashboard.php");
    exit();
}

$artworks = [];
$query = mysqli_query($conn, "SELECT title, artist, year_created, description FROM artworks ORDER BY id DESC");
if($query){
    $artworks = mysqli_fetch_all($query, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Museum</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="page-wrap">
    <section class="wrap">
        <h1>Museum Collection</h1>
        <p class="muted-text">Discover the artworks currently on display in the museum.</p>
        <?php if(empty($artworks)): ?>
            <p>No museum artworks available yet.</p>
        <?php else: ?>
            <div class="museum-grid">
                <?php foreach($artworks as $artwork): ?>
                    <article class="item museum-card">
                        <h3><?php echo htmlspecialchars($artwork['title']); ?></h3>
                        <p><strong>Artist:</strong> <?php echo htmlspecialchars($artwork['artist']); ?></p>
                        <p><strong>Year:</strong> <?php echo htmlspecialchars($artwork['year_created'] ?: 'Unknown'); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($artwork['description'])); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="page-actions">
            <a class="btn btn-secondary" href="dashboard.php">Back to Dashboard</a>
        </div>
    </section>
</div>
<footer class="site-footer">
    <div class="footer-wrap">
        <span>Lekiri Books &copy; All rights reserved 2026</span>
    </div>
</footer>
</body>
</html>
