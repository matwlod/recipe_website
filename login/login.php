<?php

$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$password = $_POST['password'];
$email=mysqli_real_escape_string($conn,htmlspecialchars($email));
$password=mysqli_real_escape_string($conn,htmlspecialchars($password));

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
    $row = $result->fetch_assoc();
    if (password_verify($password,$row['Password'])) {
        echo "Login successful!";
        
        $_SESSION["nickname"]=$row['Name'];
        $_SESSION["userid"]=$row['ID'];
        $id=$_SESSION["userid"];
        $sql = "SELECT * FROM admins WHERE userID='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $_SESSION['admin']=TRUE;
        }
        else
        {
            $_SESSION['admin']=FALSE;
        }
        header("Location: /");
        
    } else {
    $error_message = "Invalid password";
    echo "<script>alert('$error_message'); window.location.href='./index.php';</script>";
    }
} else {
    $error_message = "User not found";
    echo "<script>alert('$error_message'); window.location.href='./index.php';</script>";

}


$conn->close();
?>
