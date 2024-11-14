<?php 
session_start();
if (!isset($_SESSION["nickname"])){
	$_SESSION["nickname"]="guest";
	$_SESSION["userid"]=-1;
	$_SESSION["admin"]=FALSE;
	$userId=$_SESSION["userid"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="../css/add.css">
</head>
<body>
    <div id="container">
        <div class="header">
			<a href='/' style='color: white; text-decoration: none;'><h1>Logo</h1></a>
            
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
            <div class="add-recipe-box">
                <h2>Add a New Recipe</h2>
                
                <form action="save_recipe.php" method="post" enctype="multipart/form-data">
                    <label for="recName">Recipe Name:</label>
                    <input type="text" name="recName" required><br><br>
                    

                    <div class='category-box'>
                    <label for="category">Category:</label>
                    <select class='category-select' name="category" required>
                    
        <?php
$conn = mysqli_connect("localhost","testroot","123","maindb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT * FROM categories";
$result = $conn->query($query);


while ($row = $result->fetch_assoc()) {
    $catID = $row['catID'];
    $catName = $row['catName'];
    echo "<option value='$catID'>$catName</option>";
}
$conn->close();
        ?>

</select><br><br>
</div>



                    <label for="ingredients">Ingredients: (separated by comma)</label>
                    <textarea name="ingredients" required></textarea><br><br>
                    
                    <label for="instructions">Instructions:</label>
                    <textarea name="instructions" required></textarea><br><br>

                    <label for="image">Upload Image (JPG only):</label>
                    <input type="file" name="image" accept=".jpg"><br><br>
                    
                    <input class="save-recipe-btn" type="submit" value="Save Recipe">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
