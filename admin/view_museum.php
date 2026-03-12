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
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:rgba(0,0,24,.967);color:#fff}
        .wrap{width:min(900px,92%);margin:40px auto}
        .item{background:rgba(46,204,113,.75);padding:16px;border-radius:10px;margin-bottom:12px}
        a{color:#fff}
    </style>
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
