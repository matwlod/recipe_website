<?php
// edit_recipe.php

// Start the session
session_start();

// Check if the user is an admin
if (!isset($_SESSION['admin']) && (!isset($_SESSION['userid']) || $_SESSION['userid'] !== $row['UserID'])) {
    echo "You don't have permission to edit recipes.";
    exit();
}

// Establish a connection to the database
$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$recipeId = $_POST['recipeId'];

// Fetch existing recipe data
$sqlFetchRecipe = "SELECT * FROM recipes WHERE ID='$recipeId'";
$resultFetchRecipe = $conn->query($sqlFetchRecipe);

if ($resultFetchRecipe->num_rows > 0) {
    $row = $resultFetchRecipe->fetch_assoc();
    $recName = $row['RecName'];
    $ingredients = $row['Ingredients'];
    $instructions = $row['Instructions'];
} else {
    echo "Recipe not found.";
}
?>

    
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Edit Recipe</title>
        <link rel='stylesheet' type='text/css' href='../css/edit.css'>
    </head>
    <body>
    <div id="container">
            <div class="header">
                <h1>Logo</h1>

                <ul>
                    
                    <?php if ($_SESSION['nickname']=="guest"){
                        echo '<li><a href="/login">Login</a></li>';
                    }?>
                    <?php if ($_SESSION['nickname']=="guest"){
                        echo '<li><a href="/register">Register</a></li>';
                    }?>
                    <?php if ($_SESSION['nickname']!="guest"){
                        echo '<li><a href="/add">Add recipe</a></li>';
                    }?>
                    
                    <?php if ($_SESSION['nickname']!="guest"){
                        echo '<li><a href="/favourites">Favorites</a></li>';
                    }?>
                    
                    <?php if ($_SESSION['nickname']!="guest"){
                        echo '<li><a href="/logout">Logout</a></li>';
                    }?>
                    
                </ul>
            </div>

            <div class="main">
                <div class='edit-recipe-box'>
                    <h1>Edit Recipe</h1>
                    <form action='update_recipe.php' method='post'>
                        <input type='hidden' name='recipeId' value='<?php echo $recipeId?>'>
                        <label for='recName'>Recipe Name:</label>
                        <input type='text' name='recName' value='<?php echo $recName?>' required><br>
                        <label for='ingredients'>Ingredients:</label>
                        <textarea name='ingredients' rows='4' cols='50' required><?php echo $ingredients?></textarea><br>
                        <label for='instructions'>Instructions:</label>
                        <textarea name='instructions' rows='4' cols='50' required><?php echo $instructions?></textarea><br>
                        <input class='update-recipe' type='submit' value='Update Recipe'>
                    </form>
                </div>
            </div>
    </div>
    </body>
    </html>
    


    
    <?php
$conn->close();
?>
