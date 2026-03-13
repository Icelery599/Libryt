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