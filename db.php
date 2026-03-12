<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "lybryt";
$conn = new mysqli($server, $user, $pass, $dbname);
if(!$conn){
    echo "Oopps! : {$conn->connect_error}";
}

?>