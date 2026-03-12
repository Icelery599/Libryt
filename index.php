<?php
include "db.php";
 $sql = "select * from books";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            echo "error!: {$result->error}";
        }
		else{
			
		}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		*{
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
		body{
			background: rgba(0, 0, 24, 0.967);
			background-size: cover;
		}
		header{
			position: fixed 
			top: 0;
			width: 100%;
			padding: 30px;
			background-color: rgba(120, 120, 248, 0.9);
		}
		header h1{
			color: #fff;
		}
		footer{
			position: fixed;
			bottom: 0; 
			width: 100%;
			background-color: rgba(120, 120, 248, 0.9);
			padding: 10px;
			text-align: center;
		}
		.indexsection{
			background-color: rgba(120, 120, 248, 0.9);
			display: flex;
			max-width: 450px;
			flex-wrap: wrap;
			padding: 10px;
			justify-content: center;
			margin-top: 100px;
			margin: 100px auto;
		}
		.indexsection div{
			width: 200px;
			text-align: center;
			color: white;
		}
		.indexsection img{
			width: 100%;
			margin: 10px 0;
			border-radius: 10px;
		}
	</style>
</head>
<body>
<header>
	<h1>Library home page</h1>
</header>
<section class="indexsection">
	<?php 
	while($row = mysqli_fetch_assoc($result)) { ?>
	<div class="book-details">
		<img src="image/<?php echo "{$row['image']}"?>" alt="mum_img">
		<p>Book Title:<?php echo $row['title']; ?></p>
		<p>Author:<?php echo $row['author']; ?></p>
		<p>ISBN:<?php echo $row['isbn']; ?></p>
		<p>Quantity:<?php echo $row['quantity']; ?></p>
		<a href="borrow.php?book_id=<?php echo "{$row['id']}";?>">Borrow Book</a>
	</div>
	<?php } ?>
</section>
<footer>
	<p>&copy; Lekiri Books 2026</p>
</footer>
</body>
</html>