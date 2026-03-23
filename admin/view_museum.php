<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
if($_SESSION['role'] !== 'admin'){
    header("Location: ../dashboard.php");
    exit();
}

$artworks = [];
$query = mysqli_query($conn, "SELECT id, title, artist, year_created, description, image, created_at FROM artworks ORDER BY id DESC");
if($query){
    $artworks = mysqli_fetch_all($query, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Artworks</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="page-wrap">
    <section class="wrap museum-admin-shell">
        <div class="page-title-row">
            <div>
                <h1>Museum Artworks</h1>
                <p class="muted-text">Admins can add, update, and delete artworks from here.</p>
            </div>
            <a class="btn" href="add_musuems.php">Add New Artwork</a>
        </div>

        <?php if(empty($artworks)): ?>
            <div class="item"><p>No museum artworks available yet.</p></div>
        <?php else: ?>
            <div class="museum-grid">
                <?php foreach($artworks as $artwork): ?>
                    <article class="item museum-card">
                        <?php if(!empty($artwork['image'])): ?>
                            <img class="artwork-card-image" src="../image/<?php echo htmlspecialchars($artwork['image']); ?>" alt="<?php echo htmlspecialchars($artwork['title']); ?> artwork image">
                        <?php endif; ?>
                        <span class="card-tag">Artwork #<?php echo (int)$artwork['id']; ?></span>
                        <h3><?php echo htmlspecialchars($artwork['title']); ?></h3>
                        <p><strong>Artist:</strong> <?php echo htmlspecialchars($artwork['artist']); ?></p>
                        <p><strong>Year:</strong> <?php echo htmlspecialchars($artwork['year_created'] ?: 'Unknown'); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($artwork['description'])); ?></p>
                        <div class="page-actions">
                            <a class="btn" href="edit_museum.php?id=<?php echo (int)$artwork['id']; ?>">Edit</a>
                            <a class="btn delete-btn" href="delete_museum.php?id=<?php echo (int)$artwork['id']; ?>" onclick="return confirm('Delete this artwork?');">Delete</a>
                        </div>
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
