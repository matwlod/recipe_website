<?php

session_start();


if (!isset($_SESSION['userid'])) {
    echo "You must be logged in to add a recipe to favorites.";
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


$sqlAddToFavorites = "INSERT INTO favourites (UserID, RecipeID) VALUES ('$userId', '$recipeId')";

if ($conn->query($sqlAddToFavorites) === TRUE) {
    echo "Recipe added to favorites successfully!";
    header("Location: /display_recipe?id=$recipeId");
} else {
    echo "Error adding recipe to favorites: " . $conn->error;
}


$conn->close();
?>
