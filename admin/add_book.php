<?php
session_start();
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $image = $_FILES['image']['name'];
    $quantity = $_POST['quantity'];
    include "../db.php";
    $sql = "insert into books(title, author, isbn, image, quantity) values('$title', '$author', '$isbn', '$image', '$quantity')";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "Error!: {$conn->error}";
    }else{
        $image_location = $_FILES['image']['tmp_name'];
        $upload_location = "../image/";
        move_uploaded_file($image_location, $upload_location.$image);
        echo "book added sucessfully";
    }    
}
    }
}
else{
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "../heading.php"; ?>
<style>
    *{
        margin: 0;
        padding: 0; 
    }
    body{
        background: rgba(0, 0, 24, 0.967);
        background-size: cover;
    }
    .admin{
    display: flex;
    justify-content: center;
    margin-top: 150px;
}
.admin input{
    padding: 20px;
    margin: 5px;
    border: none;
    border-bottom: 2px solid  #A020F0;
}
.admin button{
    padding: 10px;
    width: 100%;
    margin: 5px;
    border: none;
    border-radius: 2px;
    background-color: #fffc0f;
}
.admin button:hover{
    padding: 10px;
    width: 100%;
    margin: 5px;
    border: none;
    border-radius: 2px;
    background-color: #fffc5a;
    transform:  
}
.file{
    border: none !important;
    width: 100%;
}
</style>
<body>
    <div class="admin">
        <form action="add_book.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Book tile"><br>
            <input type="text" name="author" placeholder="Author"><br>
            <input type="text" name="isbn" placeholder="isbn" required><br>
            <input type="file" name="image" class="file"><br>
            <input type="text" name="quantity" placeholder="Book quantity"><br>
        <button type="submit">Add Book</button><br>
    </form>
    </div>
</body>
</html>