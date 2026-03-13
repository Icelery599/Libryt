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

$user_id = $_SESSION['user_id'];

$allQuestions = [
    "What genres do you enjoy most?" => ["Fiction", "Non-fiction", "Science", "Biography"],
    "How often do you read books?" => ["Daily", "Weekly", "Monthly", "Occasionally"],
    "What format do you prefer?" => ["Printed books", "E-books", "Audio books", "Any format"],
    "What kind of stories keep you engaged?" => ["Adventure", "Mystery", "Romance", "History"],
    "How many books do you plan to read each month?" => ["1-2", "3-4", "5-6", "7+"],
    "Do you prefer short reads or long novels?" => ["Short reads", "Long novels", "Both", "No preference"]
];

$surveyQuestions = $_SESSION['survey_questions'] ?? array_slice($allQuestions, 0, 4, true);

$sqlBooks = "SELECT b.id, b.title, b.author, b.isbn, b.quantity, b.image
             FROM books b
             ORDER BY b.id DESC
             LIMIT 8";
$resultBooks = mysqli_query($conn, $sqlBooks);
$books = $resultBooks ? mysqli_fetch_all($resultBooks, MYSQLI_ASSOC) : [];

$sqlBorrowed = "SELECT t.id, b.title, t.issue_date, t.return_date, t.status
               , b.author, b.isbn
               FROM transactions t
               INNER JOIN books b ON b.id = t.book_id
               WHERE t.user_id = '$user_id'
               ORDER BY t.id DESC";
$resultBorrowed = mysqli_query($conn, $sqlBorrowed);
$borrowedBooks = $resultBorrowed ? mysqli_fetch_all($resultBorrowed, MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <h2>User Dashboard</h2>
        <a href="#dashboard-home">Dashboard Home</a>
        <a href="view_museum.php">See Museum</a>
        <a href="#your-books">Your Books</a>
        <a href="requestcheck.php">Borrow Records</a>
        <a href="logout.php">Logout</a>
        <div class="sidebar-footer">Lekiri Books &copy; All rights reserved 2026</div>
    </aside>

    <main class="content" id="dashboard-home">
        <section class="survey-box" id="survey-section">
            <h1>Book Recommendation Survey</h1>
            <p>Answer this survey to help us know the books we can recommend for you.</p>
            <form>
                <?php foreach($surveyQuestions as $question => $options): ?>
                    <div class="survey-question">
                        <p><strong><?php echo htmlspecialchars($question); ?></strong></p>
                        <?php foreach($options as $idx => $option): ?>
                            <label class="survey-option">
                                <input type="radio" name="q_<?php echo md5($question); ?>" value="<?php echo htmlspecialchars($option); ?>">
                                <?php echo htmlspecialchars($option); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </form>
        </section>

        <section class="books-section" id="available-books">
            <h2>Available Books</h2>
            <div class="books-grid">
                <?php if(empty($books)): ?>
                    <div class="book-details"><p>Book listings are currently unavailable.</p></div>
                <?php else: ?>
                    <?php foreach($books as $book): ?>
                        <article class="book-details">
                            <img src="image/<?php echo htmlspecialchars($book['image']); ?>" alt="book image">
                            <p>Book Title: <?php echo htmlspecialchars($book['title']); ?></p>
                            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                            <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                            <p>Quantity: <?php echo htmlspecialchars($book['quantity']); ?></p>
                            <a href="borrow.php?book_id=<?php echo urlencode($book['id']); ?>">Borrow Book</a>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="panel" id="your-books">
            <h2>Your Books (Borrowed)</h2>
            <?php if(empty($borrowedBooks)): ?>
                <p>You have not borrowed any books yet.</p>
            <?php else: ?>
                <div class="books-grid">
                    <?php foreach($borrowedBooks as $record): ?>
                        <article class="book-details">
                            <p><strong>Book:</strong> <?php echo htmlspecialchars($record['title']); ?></p>
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($record['author']); ?></p>
                            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($record['isbn']); ?></p>
                            <p><strong>Issue Date:</strong> <?php echo htmlspecialchars($record['issue_date']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($record['status']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="table-shell">
                    <table>
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Charges</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($borrowedBooks as $record): ?>
                            <?php
                                $isLate = $record['status'] !== 'returned' && strtotime($record['issue_date']) < strtotime('-5 days');
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($record['title']); ?></td>
                                <td><?php echo htmlspecialchars($record['issue_date']); ?></td>
                                <td><?php echo htmlspecialchars($record['return_date'] ?: '-'); ?></td>
                                <td><?php echo htmlspecialchars($record['status']); ?></td>
                                <td><?php echo $isLate ? 'pay late charges' : 'No charges'; ?></td>
                                <td>
                                    <?php if($record['status'] !== 'returned'): ?>
                                        <a class="update return-book-btn" href="return.php?transaction_id=<?php echo urlencode($record['id']); ?>">Return Book</a>
                                    <?php else: ?>
                                        Returned
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
<footer class="site-footer">
    <div class="footer-wrap">
        <span>Lekiri Books &copy; All rights reserved 2026</span>
    </div>
</footer>
<script>
    document.querySelectorAll('.return-book-btn').forEach(function(button){
        button.addEventListener('click', function(event){
            event.preventDefault();
            alert('pay for returning the book late');
            window.location.href = button.getAttribute('href');
        });
    });
</script>
</body>
</html>
