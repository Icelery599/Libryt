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
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">

        <a href="#dashboard-home">Dashboard Home</a>
        <a href="view_museum.php">See Museum</a>
        <a href="view_books.php">Your Books</a>
        <a href="requestcheck.php">Borrow Records</a>
        <a href="logout.php">Logout</a>
    </aside>

    <main class="content" id="dashboard-home">
        <section class="survey-box" id="survey-section">
            <h1>Your Dashboard</h1>
            <h2>Book Recommendation Survey</h2>
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
                <input type="reset" value="Submit" style="max-width: 200px; hover{background:yellow;}">
            </form>
        </section>

        

       
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
