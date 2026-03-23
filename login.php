<?php
include "db.php";
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $sql);

    if($result && $result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        if($row['password'] == $password){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            if($row['role'] == "user"){
                $allQuestions = [
                    "What genres do you enjoy most?" => ["Fiction", "Non-fiction", "Science", "Biography"],
                    "How often do you read books?" => ["Daily", "Weekly", "Monthly", "Occasionally"],
                    "What format do you prefer?" => ["Printed books", "E-books", "Audio books", "Any format"],
                    "What kind of stories keep you engaged?" => ["Adventure", "Mystery", "Romance", "History"],
                    "How many books do you plan to read each month?" => ["1-2", "3-4", "5-6", "7+"],
                    "Do you prefer short reads or long novels?" => ["Short reads", "Long novels", "Both", "No preference"]
                ];
                $questionKeys = array_keys($allQuestions);
                shuffle($questionKeys);
                $picked = array_slice($questionKeys, 0, 4);
                $_SESSION['survey_questions'] = [];
                foreach($picked as $question){
                    $_SESSION['survey_questions'][$question] = $allQuestions[$question];
                }
                header("Location: dashboard.php");
            }else{
                header("Location: admin/dashboard.php");
            }
            exit();
        }
    }

    $error = "Invalid login credentials.";
}
?>

<!DOCTYPE html>
<html>
<?php include "heading.php"; ?>
<body>
    <div class="register">
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="enter your email" required><br>
            <input type="password" name="password" placeholder="enter your password" required><br>
            <button type="submit">Log in</button><br>
            <?php if(isset($error)): ?><p><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
            <p>No yet registered? <a href="register.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
