<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] !== "user"){
    header("Location: admin/dashboard.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

$sqlBorrowed = "SELECT t.id, t.issue_date, t.return_date, t.status,
                       b.title, b.author, b.isbn, b.image
                FROM transactions t
                INNER JOIN books b ON b.id = t.book_id
                WHERE t.user_id = ?
                ORDER BY t.id DESC";
$stmt = mysqli_prepare($conn, $sqlBorrowed);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$resultBorrowed = mysqli_stmt_get_result($stmt);
$borrowedBooks = $resultBorrowed ? mysqli_fetch_all($resultBorrowed, MYSQLI_ASSOC) : [];
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Books</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="dashboard.php">Dashboard Home</a>
        <a href="view_museum.php">See Museum</a>
        <a href="view_books.php">Your Books</a>
        <a href="requestcheck.php">Borrow Records</a>
        <a href="logout.php">Logout</a>
    </aside>

    <main class="content">
        <section class="books-section">
            <h1>Your Books</h1>
            <p>View books you borrowed and return books from this page.</p>

            <div class="books-grid">
                <?php if(empty($borrowedBooks)): ?>
                    <div class="book-details"><p>You have not borrowed any books yet.</p></div>
                <?php else: ?>
                    <?php foreach($borrowedBooks as $book): ?>
                        <article class="book-details">
                            <img src="image/<?php echo htmlspecialchars($book['image']); ?>" alt="book image">
                            <p>Book Title: <?php echo htmlspecialchars($book['title']); ?></p>
                            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                            <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                            <p>Issue Date: <?php echo htmlspecialchars($book['issue_date']); ?></p>
                            <p>Status: <?php echo htmlspecialchars($book['status']); ?></p>

                            <?php if($book['status'] === 'borrowed'): ?>
                                <a class="btn return-book-btn" href="return.php?transaction_id=<?php echo urlencode($book['id']); ?>">Return Book</a>
                            <?php else: ?>
                                <p>Returned on: <?php echo htmlspecialchars($book['return_date'] ?? 'N/A'); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>

<script>
    document.querySelectorAll('.return-book-btn').forEach(function(button){
        button.addEventListener('click', function(event){
            event.preventDefault();
            if (confirm('Confirm book return?')) {
                window.location.href = button.getAttribute('href');
            }
        });
    });
</script>
</body>
</html>
