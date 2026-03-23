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

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $year_created = trim($_POST['year_created'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if($title !== '' && $artist !== '' && $description !== ''){
        $stmt = $conn->prepare("INSERT INTO artworks (title, artist, year_created, description) VALUES (?, ?, ?, ?)");
        if($stmt){
            $yearValue = $year_created !== '' ? $year_created : null;
            $stmt->bind_param("ssis", $title, $artist, $yearValue, $description);
            if($stmt->execute()){
                $message = 'Artwork added successfully.';
            }else{
                $message = 'Unable to save artwork right now.';
            }
            $stmt->close();
        }else{
            $message = 'Artworks table is missing. Please import the latest database SQL.';
        }
    }else{
        $message = 'Please fill in the title, artist, and description fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Museum Artwork</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="wrap form-shell">
        <h1>Add Artwork to Museum</h1>
        <p class="muted-text">Create a museum artwork record that visitors can see and admins can manage.</p>
        <?php if($message !== ''): ?>
            <p class="status-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post" action="add_musuems.php">
            <label for="title">Artwork title</label>
            <input id="title" type="text" name="title" placeholder="Artwork title" required>

            <label for="artist">Artist name</label>
            <input id="artist" type="text" name="artist" placeholder="Artist name" required>

            <label for="year_created">Year created</label>
            <input id="year_created" type="number" name="year_created" placeholder="e.g. 1889">

            <label for="description">Artwork description</label>
            <textarea id="description" name="description" placeholder="Describe the artwork" rows="5" required></textarea>

            <button type="submit">Add Artwork</button>
        </form>
        <div class="page-actions">
            <a class="btn" href="view_museum.php">Manage Artworks</a>
            <a class="btn btn-secondary" href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
