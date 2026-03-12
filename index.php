<?php
include "db.php";

$sql = "select * from books";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $books = [];
} else {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$heroSlides = [
    [
        "title" => "Welcome to Lekiri Library",
        "description" => "Discover stories, research resources, and peaceful reading corners for every visitor.",
        "image" => "Gemini_Generated_Image_2ks0y02ks0y02ks0.png",
    ],
    [
        "title" => "Explore Our Museum Corner",
        "description" => "Step through local history exhibits and curated cultural artifacts.",
        "image" => "Gemini_Generated_Image_2ks0y02ks0y02ks0.png",
    ],
    [
        "title" => "Books, Heritage & Community",
        "description" => "From timeless classics to modern discoveries, there is something for everyone.",
        "image" => "Gemini_Generated_Image_2ks0y02ks0y02ks0.png",
    ],
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lekiri Library</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: rgba(0, 0, 24, 0.967);
            color: #fff;
            font-family: Arial, sans-serif;
        }

        header {
            width: 100%;
            padding: 24px;
            background-color: rgba(120, 120, 248, 0.9);
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .page-wrap {
            width: min(1100px, 92%);
            margin: 35px auto 40px;
        }

        .slideshow {
            background-color: rgba(120, 120, 248, 0.9);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            margin-bottom: 35px;
        }

        .slide {
            display: none;
            grid-template-columns: 1.2fr 1fr;
            gap: 16px;
            align-items: center;
            padding: 18px;
        }

        .slide.active {
            display: grid;
        }

        .slide img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.35);
        }

        .slide-content h2 {
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .slide-content p {
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .slide-content a {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: rgba(0, 0, 24, 0.967);
            background: #fff312;
            font-weight: bold;
        }

        .dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 0 0 18px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            border: none;
            cursor: pointer;
        }

        .dot.active {
            background: #fff312;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .book-details {
            background-color: rgba(120, 120, 248, 0.9);
            border-radius: 12px;
            padding: 12px;
        }

        .book-details img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .book-details p {
            margin: 4px 0;
        }

        .book-details a {
            display: inline-block;
            margin-top: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        footer {
            width: 100%;
            background-color: rgba(120, 120, 248, 0.9);
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 760px) {
            .slide {
                grid-template-columns: 1fr;
            }

            .slide img {
                height: 220px;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>Library & Museum Home Page</h1>
</header>

<div class="page-wrap">
    <section class="slideshow" aria-label="Library and museum highlights">
        <?php foreach ($heroSlides as $index => $slide): ?>
            <article class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                <img src="image/<?php echo $slide['image']; ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>">
                <div class="slide-content">
                    <h2><?php echo htmlspecialchars($slide['title']); ?></h2>
                    <p><?php echo htmlspecialchars($slide['description']); ?></p>
                    <a href="register.php">Join the Community</a>
                </div>
            </article>
        <?php endforeach; ?>

        <div class="dots" aria-label="Slideshow navigation">
            <?php foreach ($heroSlides as $index => $_): ?>
                <button class="dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>" aria-label="Go to slide <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="books-grid">
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
    </section>
</div>

<footer>
    <p>&copy; Lekiri Books 2026</p>
</footer>

<script>
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let index = 0;

    function showSlide(nextIndex) {
        slides[index].classList.remove('active');
        dots[index].classList.remove('active');

        index = (nextIndex + slides.length) % slides.length;

        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            showSlide(Number(dot.dataset.slide));
        });
    });

    setInterval(() => {
        showSlide(index + 1);
    }, 4500);
</script>
</body>
</html>
