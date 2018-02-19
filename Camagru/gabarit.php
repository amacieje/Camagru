<!-- Gabarit commun a toutes les pages du Site -->

<!DOCTYPE html>
<html lang="fr-FR">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content"width=device-width">
		<link rel=stylesheet href=camagru.css>
		<title><?PHP echo $page_title . " - Camagru" ?></title> <!-- Element specifique -->
	</head>

	<body>
		<div id="global">
			<header>
				<a href="index.php"><h1 id="title">Camagru</h1></a>
				<?PHP
				if (isset($_SESSION['login'])) {
					ob_start(); ?>
					<a href="logout.php">Se déconnecter</a><br>
					<a href="account.php">Mon compte</a><br>
					<?PHP
					$logout = ob_get_clean();
					echo $logout;
				}
				else {
					ob_start(); ?>
					<a href="login.php">Se connecter</a><br>
					<a href="signup.php">S'inscrire</a><br>
					<?PHP
					$signin = ob_get_clean();
					echo $signin;
				} ?>

			</header>
			<div id="content">
				<?PHP echo $page_content ?> <!-- Element specifique -->
			</div>
			<hr />
			<footer id="footer">Footer text bitches !
			</footer>
		</div>
	</body>
</html>
