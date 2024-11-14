<?php session_start();
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
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

		<div class="login-box">
			<div class="login-account-icon">
				<h2>Login</h2>
				<div class="account">
					<div class="account-head"></div>
					<div class="account-body"></div>
				</div>
			</div>
			
			<form action="login.php" method="post">
				<label for="email">Email:</label>
				<input type="email" name="email" required><br><br>
				
				
				<label for="password">Password:</label>
				<input type="password" name="password" required><br><br>
				
				<input class="login-btn" type="submit" value="Login">
			</form>
		</div>
	</div>
</body>
</html>
