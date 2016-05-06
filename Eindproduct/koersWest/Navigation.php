<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/styles.css">
		<title>Navigation</title>
	</head>

	<body>
		<nav class= "navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type= "button" 
							class= "navbar-toggle collapsed"
							data-toggle="collapse"
							data-target="#collapsemenu"
							aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
			      
					<a href="about.php" class= navbar-brand>KoersWest</a>
				</div>

				<div class="collapse navbar-collapse" id = "collapsemenu">
					<ul class= "nav navbar-nav">
						<?php
						// If a user is logged in, display the normal menu bar
						if (isset($_SESSION['user_id'])) 
						{
							?>
							<li><a href="index.php">Profiel</a></li>
							<li><a href="askForService.php">Gebruikers</a></li>
							<li><a href="aanbiedMenu.php">Dienst aanbieden</a></li>
							<li><a href="logout.php">Uitloggen</a></li>
							<?php
						}
						else // Display the menu bar for logged out users
						{
							?>
							<li><a href="index.php">Home</a></li>
							<li><a href="login.php">Login</a></li>
							<li><a href="register.php">Register</a></li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</nav>

		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script> 
		<script src="js/script.js"></script>
	</body>
</html>