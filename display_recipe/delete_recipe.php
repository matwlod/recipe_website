<?php

session_start();


if (!isset($_SESSION['admin']) && (!isset($_SESSION['userid']) || $_SESSION['userid'] !== $row['UserID'])) {
    echo "You don't have permission to delete recipes.";
    exit();
}


$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$recipeId = $_POST['recipeId'];


$sqlDeleteRecipe = "DELETE FROM recipes WHERE ID='$recipeId'";

if ($conn->query($sqlDeleteRecipe) === TRUE) {
    echo "Recipe deleted successfully!";
    Header("Location: /");
} else {
    echo "Error deleting recipe: " . $conn->error;
}

$conn->close();
?>
