<?php
session_start();


if (!isset($_SESSION['admin']) && (!isset($_SESSION['userid']) || $_SESSION['userid'] !== $row['UserID'])) {
    echo "You don't have permission to update recipes.";
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
$recName = $_POST['recName'];
$ingredients = $_POST['ingredients'];
$instructions = $_POST['instructions'];

$recName=mysqli_real_escape_string($conn,htmlspecialchars($recName));
$ingredients=mysqli_real_escape_string($conn,htmlspecialchars($ingredients));
$instructions=mysqli_real_escape_string($conn,htmlspecialchars($instructions));
$recipeId=mysqli_real_escape_string($conn,htmlspecialchars($recipeId));


$sqlUpdateRecipe = "UPDATE recipes SET RecName='$recName', Ingredients='$ingredients', Instructions='$instructions' WHERE ID='$recipeId'";

if ($conn->query($sqlUpdateRecipe) === TRUE) {
    echo "Recipe updated successfully!";
    Header("Location: /");
} else {
    echo "Error updating recipe: " . $conn->error;
}


$conn->close();
?>
