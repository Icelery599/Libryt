<?php
include "db.php";
session_start();

$sql = "select * from books";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $books = [];
} else {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$borrowLink = isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lekiri Library</title>
        <link rel="stylesheet" href="/styles.css">
</head>
<body>
<header>
    <div class="header-wrap">
        <h1>Libryt Landing Page</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#books">Books</a></li>
                <li><a href="#museums">Museums</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="page-wrap">
    <section id="home" class="hero">
        <h2 class="welcome-title">Welcome to Libryt</h2>
        <p class="welcome-copy">A modern e-library for curious minds. Discover timeless books, explore digital museum stories, and grow your knowledge from anywhere.</p>
        <a class="btn borrow-now" href="<?php echo htmlspecialchars($borrowLink); ?>">Borrow Now</a>
    </section>

    <section id="about" class="hero about-section">
        <div class="about-copy">
            <h2>About Us</h2>
            <p>Libryt connects free reading resources with cultural learning so everyone can discover, borrow, and enjoy meaningful content online.</p>
            <p>From classics to modern discoveries, our platform is built to feel fast, beautiful, and easy to use for every reader.</p>
        </div>
        <div class="about-image-wrap">
            <img src="image/Gemini_Generated_Image_2ks0y02ks0y02ks0.png" alt="Modern library interior">
        </div>
    </section>

    <section id="books" class="books-section">
        <h2>Get our books for free</h2>
        <div class="split-grid">
            <div>
                <p>Borrow from our collection at no cost and keep your reading journey active.</p>
            </div>
            <img src="image/Gemini_Generated_Image_2ks0y02ks0y02ks0.png" alt="Books and reading area">
        </div>

        <div class="books-grid">
            <?php if (empty($books)): ?>
                <div class="book-details">
                    <p>Book listings are currently unavailable. Please check back soon.</p>
                </div>
            <?php else: ?>
                <?php foreach ($books as $row): ?>
                    <div class="book-details">
                        <img src="image/<?php echo htmlspecialchars($row['image']); ?>" alt="book image">
                        <p>Book Title: <?php echo htmlspecialchars($row['title']); ?></p>
                        <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>
                        <p>ISBN: <?php echo htmlspecialchars($row['isbn']); ?></p>
                        <p>Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p>
                        <a href="borrow.php?book_id=<?php echo urlencode($row['id']); ?>">Borrow Book</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section id="museums" class="museums-section">
        <h2>Dive into our museums for history</h2>
        <div class="split-grid">
            <div>
                <p>Explore exhibits that tell the stories of culture, people, and moments that shaped our world.</p>
            </div>
            <img src="image/Gemini_Generated_Image_2ks0y02ks0y02ks0.png" alt="Museum exhibit">
        </div>
    </section>
</div>

<footer>
    <div class="footer-wrap">
        <span>Contact Us</span>
        <span>FAQ</span>
        <span>Follow us on social media</span>
        <span>Copyright © 2026. All rights reserved.</span>
    </div>
</footer>
</body>
</html>
