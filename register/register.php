<?php
session_start();

$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password=password_hash($password, PASSWORD_BCRYPT);
$name=mysqli_real_escape_string($conn,htmlspecialchars($name));
$email=mysqli_real_escape_string($conn,htmlspecialchars($email));

$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";



if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
    header("Location: /");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
