<?php
session_start();

if (!isset($_SESSION["nickname"])){
	$_SESSION["nickname"]="guest";
	$_SESSION["userid"]=-1;
	$_SESSION["admin"]=FALSE;
	
}

if(isset($_SESSION["admin"]))

	$conn = mysqli_connect("localhost","testroot","123","maindb");
	
	$recipesPerPage = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$startFrom = ($page - 1) * $recipesPerPage;
$catID = isset($_GET['catID']) ? $_GET['catID'] : null;
$userId=$_SESSION['userid'];
$query="SELECT recipes.* FROM recipes
    INNER JOIN favourites ON recipes.ID = favourites.RecipeID
    WHERE favourites.UserID = '$userId'";
$queryout = mysqli_query($conn, $query);
$recipes = mysqli_fetch_all($queryout, MYSQLI_ASSOC);
	
?>




<head>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Simple House Template</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" />    
	<link href="../css/style.css" rel="stylesheet" />
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
		<?php
$query = "SELECT * FROM categories";
$res = $conn->query($query);
if ($res->num_rows > 0) {
	echo "<div class='categories'>";
    while ($row = $res->fetch_assoc()) {
        $catID = $row['catID'];
        $catName = $row['catName'];
		
        echo "<button class='categories-btn'><a href='/category?catID=$catID'>$catName</a></button>";
    }
	echo "</div>";
} else {
    echo "No categories found.";
}?>

		<div class="main">

			<div class="aside-1">
				<img class="aside-photo1 aside-photo" height="100%" src="../img/aside1--img0.jpg" alt="">
			</div>
			
		

			<div class="item-container">
				
					<?php foreach ($recipes as $rec) { ?>
						<a href="/display_recipe?id=<?php echo $rec["ID"] ?>">
							<div class="item">
									<img class="item-photo" src=../<?php echo $rec["photoname"] !== "" ? "img/".$rec["photoname"] : 'img/gallery/04.jpg'; ?> alt="Image" href="display_recipe?id=<?php echo $rec["ID"] ?>">
									<span class="item-name"><?php echo $rec['RecName'] ?></span>
									<button class="show-recipe-btn">Show recipe</button>
							</div>
						</a>
					<?php } ?>
			
			</div>


			<div class="aside-2">
				<img class="aside-photo2 aside-photo" height="100%" src="../img/aside1--img0.jpg" alt="">
			</div>
			

		</div>



			
			<div class="pagination">
				<?php
				$totalRecipes = mysqli_num_rows(mysqli_query($conn, $query));
				$totalPages = ceil($totalRecipes / $recipesPerPage);

				for ($i = 1; $i <= $totalPages; $i++) {
					echo "<a class='page-numbers' href='?page=$i'>$i</a> ";
				}
				?>
			</div>
		</div> 
    <script src="../js/slider23.js"></script>
</body>







