<?php
include "db.php";

$sql = "select * from books";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $books = [];
} else {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lekiri Library</title>
    <style type="text/css">
        * { padding: 0; margin: 0; box-sizing: border-box; }

        :root {
            --bg-dark: rgba(0, 0, 24, 0.967);
            --panel: rgba(120, 120, 248, 0.9);
            --highlight: #fff312;
            --text: #ffffff;
        }

        body {
            background: var(--bg-dark);
            color: var(--text);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            width: 100%;
            padding: 20px;
            background-color: var(--panel);
        }

        .header-wrap {
            width: min(1100px, 92%);
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 12px;
            flex-wrap: wrap;
        }

        nav a {
            color: var(--text);
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 7px;
            background: rgba(0, 0, 0, 0.2);
        }

        nav a:hover {
            background: var(--highlight);
            color: var(--bg-dark);
        }

        .page-wrap {
            width: min(1100px, 92%);
            margin: 30px auto;
            flex: 1;
        }

        .hero, .books-section, .museums-section {
            background-color: var(--panel);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .hero p { line-height: 1.5; }

        .split-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            align-items: center;
            margin-top: 12px;
        }

        .split-grid img {
            width: 100%;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            max-height: 260px;
            object-fit: cover;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            margin-top: 14px;
        }

        .book-details {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 12px;
        }

        .book-details img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .book-details p { margin: 4px 0; }

        .book-details a {
            display: inline-block;
            margin-top: 8px;
            text-decoration: none;
            font-weight: bold;
            color: var(--bg-dark);
            background: var(--highlight);
            padding: 8px 10px;
            border-radius: 6px;
        }

        footer {
            background-color: var(--panel);
            padding: 16px;
        }

        .footer-wrap {
            width: min(1100px, 92%);
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            justify-content: space-between;
            font-size: 0.95rem;
        }
    </style>
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
        <h2>Welcome to Libryt</h2>
        <p>A home for readers and history lovers. Find books, explore museums, and learn every day.</p>
    </section>

    <section id="about" class="hero">
        <h2>About Us</h2>
        <p>Libryt connects free reading resources with museum learning so everyone can discover knowledge.</p>
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
