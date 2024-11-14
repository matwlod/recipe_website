<?php
// delete_comment.php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo "You must be logged in to delete a comment.";
    exit();
}
print_r($_POST);
// Establish a connection to the database
$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$commentId = $_POST['commentID'];
$userId = $_SESSION['userid'];

$sqlCheckAuthor = "SELECT * FROM comments WHERE commentID='$commentId' AND UserID='$userId'";
$resultCheckAuthor = $conn->query($sqlCheckAuthor);
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];
if (($resultCheckAuthor->num_rows > 0)||$isAdmin) {
   
    $sqlDeleteComment = "DELETE FROM comments WHERE commentID='$commentId'";
    if ($conn->query($sqlDeleteComment) === TRUE) {
       
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error deleting comment: " . $conn->error;
    }
} else {
    echo "You don't have permission to delete this comment.";
}


$conn->close();
