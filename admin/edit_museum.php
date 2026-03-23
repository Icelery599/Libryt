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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$message = '';

$stmt = $conn->prepare("SELECT id, title, artist, year_created, description, image FROM artworks WHERE id = ?");
if(!$stmt){
    die('Artworks table is missing the latest fields. Please import the latest database SQL.');
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$artwork = $result->fetch_assoc();
$stmt->close();

if(!$artwork){
    header("Location: view_museum.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $year_created = trim($_POST['year_created'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $newImage = $_FILES['image']['name'] ?? '';
    $image = $newImage !== '' ? $newImage : ($artwork['image'] ?? '');

    if($title !== '' && $artist !== '' && $description !== '' && $image !== ''){
        $update = $conn->prepare("UPDATE artworks SET title = ?, artist = ?, year_created = ?, description = ?, image = ? WHERE id = ?");
        if($update){
            $yearValue = $year_created !== '' ? (int) $year_created : null;
            $update->bind_param("ssissi", $title, $artist, $yearValue, $description, $image, $id);
            if($update->execute()){
                if($newImage !== ''){
                    $imageLocation = $_FILES['image']['tmp_name'] ?? '';
                    if($imageLocation !== ''){
                        move_uploaded_file($imageLocation, "../image/" . $newImage);
                    }
                }
                $update->close();
                header("Location: view_museum.php");
                exit();
            }
            $message = 'Unable to update artwork right now.';
            $update->close();
        }else{
            $message = 'Artworks table is missing the latest fields. Please import the latest database SQL.';
        }
    }else{
        $message = 'Please fill in the title, artist, description, and image fields.';
    }

    $artwork = [
        'id' => $id,
        'title' => $title,
        'artist' => $artist,
        'year_created' => $year_created,
        'description' => $description,
        'image' => $image,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artwork</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="wrap form-shell">
        <h1>Edit Artwork</h1>
        <?php if($message !== ''): ?>
            <p class="status-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="title">Artwork title</label>
            <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($artwork['title']); ?>" required>

            <label for="artist">Artist name</label>
            <input id="artist" type="text" name="artist" value="<?php echo htmlspecialchars($artwork['artist']); ?>" required>

            <label for="year_created">Year created</label>
            <input id="year_created" type="number" name="year_created" value="<?php echo htmlspecialchars((string) ($artwork['year_created'] ?? '')); ?>">

            <?php if(!empty($artwork['image'])): ?>
                <label>Current artwork image</label>
                <img class="artwork-preview" src="../image/<?php echo htmlspecialchars($artwork['image']); ?>" alt="Current artwork image">
            <?php endif; ?>

            <label for="image">Replace artwork image</label>
            <input id="image" type="file" name="image" class="file" accept="image/*">

            <label for="description">Artwork description</label>
            <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($artwork['description']); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
        <div class="page-actions">
            <a class="btn btn-secondary" href="view_museum.php">Back to Artworks</a>
        </div>
    </div>
</body>
</html>
