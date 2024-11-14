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


$recName = $_POST['recName'];
$ingredients = $_POST['ingredients'];
$instructions = $_POST['instructions'];
$categoryId = $_POST['category'];

$recName=mysqli_real_escape_string($conn,htmlspecialchars($recName));
$ingredients=mysqli_real_escape_string($conn,htmlspecialchars($ingredients));
$instructions=mysqli_real_escape_string($conn,htmlspecialchars($instructions));
$categoryId=mysqli_real_escape_string($conn,htmlspecialchars($categoryId));
if (isset($_FILES['image'])) {
    $targetDir = "../img/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  
    if ($imageFileType != "jpg") {
        $error_message = "No imagine selected";
        echo "<script>alert('$error_message'); window.location.href='./index.php';</script>";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            

            $userId = $_SESSION['userid'];
            $photoName = basename($_FILES["image"]["name"]);
            $photoName=mysqli_real_escape_string($conn,htmlspecialchars($photoName));
            $sql = "INSERT INTO recipes (RecName, Ingredients, Instructions, UserID, PhotoName, catID) 
                    VALUES ('$recName', '$ingredients', '$instructions', '$userId', '$photoName', '$categoryId')";

            if ($conn->query($sql) === TRUE) {
                echo "Recipe saved successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    $error_message = "No imagine selected";
    echo "<script>alert('$error_message'); window.location.href='./index.php';</script>";
}

header ("Location: /");
$conn->close();
?>
