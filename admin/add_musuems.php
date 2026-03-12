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
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if($title !== '' && $description !== ''){
        $items = [];
        if(file_exists($file_path)){
            $items = json_decode(file_get_contents($file_path), true) ?: [];
        }

        $items[] = [
            'title' => $title,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        file_put_contents($file_path, json_encode($items, JSON_PRETTY_PRINT));
        $message = 'Museum item added successfully.';
    }else{
        $message = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Museum Item</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:rgba(0,0,24,.967);color:#fff}
        .wrap{width:min(560px,92%);margin:70px auto;background:rgba(46,204,113,.85);padding:24px;border-radius:12px}
        input,textarea,button{width:100%;padding:12px;margin-top:10px;border:none;border-radius:8px}
        button{background:#fff312;cursor:pointer}
        a{display:inline-block;margin-top:14px;color:#fff}
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Add Things in Museum</h1>
        <?php if($message !== ''): ?><p><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
        <form method="post" action="add_musuems.php">
            <input type="text" name="title" placeholder="Item title" required>
            <textarea name="description" placeholder="Item description" rows="5" required></textarea>
            <button type="submit">Add Item</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
