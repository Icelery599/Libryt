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
    $image = $_FILES['image']['name'] ?? '';

    if($title !== '' && $artist !== '' && $description !== '' && $image !== ''){
        $stmt = $conn->prepare("INSERT INTO artworks (title, artist, year_created, description, image) VALUES (?, ?, ?, ?, ?)");
        if($stmt){
            $yearValue = $year_created !== '' ? (int) $year_created : null;
            $stmt->bind_param("ssiss", $title, $artist, $yearValue, $description, $image);
            if($stmt->execute()){
                $imageLocation = $_FILES['image']['tmp_name'] ?? '';
                $uploadLocation = "../image/";
                if($imageLocation !== ''){
                    move_uploaded_file($imageLocation, $uploadLocation . $image);
                }
                $message = 'Artwork added successfully.';
            }else{
                $message = 'Unable to save artwork right now.';
            }
            $stmt->close();
        }else{
            $message = 'Artworks table is missing the latest fields. Please import the latest database SQL.';
        }
    }else{
        $message = 'Please fill in the title, artist, description, and image fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artwork</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="wrap form-shell">
        <h1>Add Artwork</h1>
        <p class="muted-text">Upload artwork details so they appear in the museum collection like books do in the library.</p>
        <?php if($message !== ''): ?>
            <p class="status-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post" action="add_musuems.php" enctype="multipart/form-data">
            <label for="title">Artwork title</label>
            <input id="title" type="text" name="title" placeholder="Artwork title" required>

            <label for="artist">Artist name</label>
            <input id="artist" type="text" name="artist" placeholder="Artist name" required>

            <label for="year_created">Year created</label>
            <input id="year_created" type="number" name="year_created" placeholder="e.g. 1889">

            <label for="image">Artwork image</label>
            <input id="image" type="file" name="image" class="file" accept="image/*" required>

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
