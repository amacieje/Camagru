<?PHP
  session_start();
  require 'Modele.php';
  $page_title = 'Connexion';

if (isset($_SESSION['login'])) {
	ob_start(); ?>
	<p>Vous êtes connecté(e) en tant que <?PHP echo $_SESSION['login']; ?>. <br></p>
	<?PHP
	$page_content = ob_get_clean();
}

else if (isset($_POST['login']) && !empty($_POST['login'])
  AND isset($_POST['password']) && !empty($_POST['password'])) {
    $hash = "";
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $bdd = get_bdd();
    $query = $bdd->query('SELECT login, password, valid FROM users');
    while ($current_line = $query->fetch()) {
      if ($current_line['login'] == $login && $current_line['valid'] == '1')
        $hash = $current_line['password'];
    }
    $query->closeCursor();
    if (password_verify($password, $hash)) {
      $_SESSION['login'] = $_POST['login'];
      $page_content = "<p>Connexion réussie. Démarrer l'expérience Camagru.</p>";
    }
    else
      $page_content = "<p>Identifiants incorrects ou compte inactif. Veuillez recommencer.</p>";
  }

else {
  ob_start(); ?>
  <form action="login.php" method="post">
    <p>
      <label for="login">Login : </label>
      <input type="text" name="login" value="" /><br>
      <label for="password">Mot de passe : </label>
      <input type="password" name="password" value="" /><br>
      <input type="submit" class="submit_button" value="Connexion" />
    </p>
  </form>
  <?PHP
  $page_content = ob_get_clean();
}

  require 'gabarit.php'; ?>
