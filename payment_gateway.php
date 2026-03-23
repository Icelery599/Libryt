<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$transaction_id = isset($_GET['transaction_id']) ? (int)$_GET['transaction_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="page-wrap">
        <section class="panel">
            <h1>Payment Gateway</h1>
            <p>Please pay for returning the book late.</p>
            <?php if($transaction_id > 0): ?>
                <p>Transaction ID: <strong><?php echo htmlspecialchars((string)$transaction_id); ?></strong></p>
            <?php endif; ?>
            <p>Late return fee: <strong>$5.00</strong></p>
            <a class="btn" href="dashboard.php">Pay now</a>
        </section>
    </main>
</body>
</html>
