<?PHP
  session_start();
  session_destroy();
  $page_title = 'Déconnexion';

	ob_start(); ?>
	<p>Déconnexion réussie. A bientôt <?PHP echo $_SESSION['login']; ?> !<br>
  <a href="http://localhost:8080/Camagru/index.php">Retourner à l'accueil</a></p>
	<?PHP
	$page_content = ob_get_clean();

  require 'gabarit.php'; ?>
