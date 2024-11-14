<?php


session_start();

$servername = "localhost";
$username = "testroot";
$password = "123";
$dbname = "maindb";
$loggedIn = isset($_SESSION['nickname'])&&$_SESSION['nickname']!='guest';
$conn = new mysqli($servername, $username, $password, $dbname);
if (!isset($_SESSION["nickname"])){
	$_SESSION["nickname"]="guest";
	$_SESSION["userid"]=-1;
	$_SESSION["admin"]=FALSE;
	$userId=$_SESSION["userid"];
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$recipeId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$recipeId) {
    echo "Invalid recipe ID.";
    exit();
}

$sql = "SELECT * FROM recipes WHERE ID='$recipeId'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();

    $recName = $row['RecName'];
    $ingredients = $row['Ingredients'];
    $instructions = $row['Instructions'];
    $owner=$row['UserID'];

    $isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];

    
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>{$recName}</title>
        <link rel='stylesheet' type='text/css' href='../css/recipe.css'>
    </head>
    <body>
    <div id='container'>
        <div class='header'>
        <a href='/' style='color: white; text-decoration: none;'><h1>Logo</h1></a>
            <ul>";
    
    if ($_SESSION['nickname'] == "guest") {
        echo "<li><a href='/login'>Login</a></li>";
    }
    
    if ($_SESSION['nickname'] == "guest") {
        echo "<li><a href='/register'>Register</a></li>";
    }
    
    if ($_SESSION['nickname'] != "guest") {
        echo "<li><a href='/add'>Add recipe</a></li>";
    }
    
    if ($_SESSION['nickname'] != "guest") {
        echo "<li><a href='/favourites'>Favorites</a></li>";
    }
    
    if ($_SESSION['nickname'] != "guest") {
        echo "<li><a href='/logout'>Logout</a></li>";
    }
    echo "</ul>
        </div>";

    echo "
        <div class='recipe-box'>
        <h1>{$recName}</h1>"
        ;
    if ($isAdmin||$_SESSION['userid']==$owner) {
        echo "
        <div class='edit-delete-add'>
        <div class='edit-delete'>
            <form action='edit_recipe.php' method='post'>
                <input type='hidden' name='recipeId' value='$recipeId'>
                <input class='edit-recipie-btn' type='submit' value='Edit Recipe'>
            </form>
            
            <form action='delete_recipe.php' method='post'>
                <input type='hidden' name='recipeId' value='$recipeId'>
                <input class='delete-recipe-btn' type='submit' value='Delete Recipe'>
            </form>
        </div>
        ";
    }
    
    
    $recPhoto=$row["photoname"] !== "" ? "img/".$row["photoname"] : 'img/gallery/04.jpg';
    if($loggedIn){
        $userId = $_SESSION['userid'];
    $recipeId = $row['ID']; 
   
    $sqlCheckFavorite = "SELECT * FROM favourites WHERE UserID='$userId' AND RecipeID='$recipeId'";
    $resultCheckFavorite = $conn->query($sqlCheckFavorite);
    if ($resultCheckFavorite->num_rows === 0) {
        echo "
            <form action='add_to_favorites.php' method='post'>
                <input type='hidden' name='userId' value='$userId'>
                <input type='hidden' name='recipeId' value='$recipeId'>
                <input type='submit' class='remove-from-favorites-btn' value='Add to Favorites'>
            </form>
          
        ";
        if ($isAdmin||$_SESSION['userid']==$owner)echo"</div>";
    }
    
    else{
        echo "
        <form action='remove_from_favorites.php' method='post'>
            <input type='hidden' name='userId' value='$userId'>
            <input type='hidden' name='recipeId' value='$recipeId'>
            <input class='remove-from-favorites-btn' type='submit' value='Remove from Favorites'>
        </form>
        
        ";
        if ($isAdmin||$_SESSION['userid']==$owner)echo"</div>";
    }}
    echo
        "
        <div class='item-photo-desc'>
        

        <div class='ingredients-instructions'>
            <h3>Ingredients:</h3>";
            echo "<ul class='ingredients'>";

$ingredientsArray = explode(',', $ingredients);
echo "<ul class='ingredients'>";
foreach ($ingredientsArray as $ingredient) {
    echo "<li>{$ingredient}</li>";
}
echo "</ul>";
            echo"<h3>Instructions:</h3>
            <ul class='instructions'>
                <li>{$instructions}</li>
            </ul>
        </div>
        <img class='item-photo' src='../{$recPhoto}'>
    </div>
        
";
} else {
    echo "Recipe not found.";
}




$sqlComments = "SELECT * FROM comments WHERE RecipeID='$recipeId' ORDER BY commentDate DESC";
$resultComments = $conn->query($sqlComments);

echo "<h3>Comments</h3>";
$sqlComments = "SELECT comments.*, users.Name AS UserName FROM comments
                LEFT JOIN users ON comments.UserID = users.ID
                WHERE RecipeID='$recipeId'
                ORDER BY commentDate DESC";

$resultComments = $conn->query($sqlComments);

if ($resultComments->num_rows > 0) {
    while ($rowComment = $resultComments->fetch_assoc()) {
        $commentUser = $rowComment['UserName']; 
        $commentText = $rowComment['commentText'];
        $commentDate = $rowComment['commentDate'];
        $commentUserId = $rowComment['UserID'];

        echo "
        <div class='comments-box'>
            <div class='comment'>
                <div class='user-date'>
                    <p><strong>User: $commentUser</strong></p>
                    <p><em>Posted on: $commentDate</em></p>
                </div>
                <span class='comment-text'>$commentText</span>
            ";

        if ((isset($_SESSION['userid']) && $_SESSION['userid'] == $commentUserId)||$isAdmin) {
            echo "<form action='delete_comment.php' method='post'>
                <input type='hidden' name='commentID' value='{$rowComment['CommentID']}'>
                <input class='delete-comment-btn' type='submit' value='&times'>
            </form>";
        }
        
        echo "</div></div>";
    }
} else {
    echo "<p>No comments yet.</p>";
}

if ($loggedIn) {
    echo "
    <h3>Add Comment</h3>
    <form class='add-comment-box' action='index.php?id=$recipeId' method='post'>
        <input type='hidden' name='recipeId' value='$recipeId'>
        <textarea name='commentText' rows='4' cols='50' required></textarea><br>
        <input class='add-comment-btn' type='submit' value='Add'>
    </form>
    ";
    
}

if ($loggedIn && isset($_POST['commentText'])) {

    $recipeId = $_POST['recipeId'];
    $userId = $_SESSION['userid'];
    $commentText = $_POST['commentText'];

    $sqlInsertComment = "INSERT INTO comments (RecipeID, UserID, commentText) VALUES ('$recipeId', '$userId', '$commentText')";
    ob_start(); 
    if ($conn->query($sqlInsertComment) === TRUE) {
        
        header("Location: ?id=$recipeId");
        ob_end_flush();
        exit();
    } else {
        echo "Error adding comment: " . $conn->error;
    }
    ob_end_flush();
}


echo '</div> </div> </body>
</html>';