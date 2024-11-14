<?php
session_start();


if (!isset($_SESSION['userid'])) {
    echo "You must be logged in to remove a recipe from favorites.";
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

$userId = $_POST['userId'];
$recipeId = $_POST['recipeId'];


$sqlRemoveFromFavorites = "DELETE FROM favourites WHERE UserID='$userId' AND RecipeID='$recipeId'";

if ($conn->query($sqlRemoveFromFavorites) === TRUE) {
    echo "Recipe removed from favorites successfully!";
    header("Location: /display_recipe?id=$recipeId");
} else {
    echo "Error removing recipe from favorites: " . $conn->error;
}


$conn->close();
?>
