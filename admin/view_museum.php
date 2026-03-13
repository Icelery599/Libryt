<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
if($_SESSION['role'] !== 'admin'){
    header("Location: ../dashboard.php");
    exit();
}

$file_path = __DIR__ . '/../museum_items.json';
$items = [];
if(file_exists($file_path)){
    $items = json_decode(file_get_contents($file_path), true) ?: [];
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
<div class="wrap">
    <h1>Museum Items</h1><br>
    <?php if(empty($items)): ?>
        <p>No museum items available yet.</p>
    <?php else: ?>
        <?php foreach($items as $item): ?>
            <article class="item">
                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
