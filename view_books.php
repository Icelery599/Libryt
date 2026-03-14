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
                    <form action="borrow.php" method="post">
                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                        <button type="submit">Send Borrow Request</button>
                    </form>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
