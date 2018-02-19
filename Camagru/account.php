<?PHP
  session_start();
  require 'Modele.php';
  $page_title = 'Mon compte';

if (isset($_SESSION['login'])) {
	ob_start(); ?>
	<p>Bienvenue sur votre espace personnel, <?PHP echo $_SESSION['login']; ?>. <br></p>

  <p>Modifier mon mot de passe :<br></p>
  <form action="account.php" method="post">
	<p>
		<label for "old_pswd">Ancien mot de passe :</label>
    <input type="password" name="old_pswd" /><br>

		<label for "password">Nouveau mot de passe :</label>
    <input id="psw" type="password" name="password"
		pattern=".{8,}" title="Veuillez choisir un mot de passe d'une longueur minimale de 8 carctères." /><br>
    <div id="message">
      <p id="length" class="invalid">Mot de passe d'une longueur minimale de <b>8 caractères</b>.</p>
    </div>

    <label for="password">Confirmer le mot de passe :</label>
		<input type="password" name="password_confirm" />
		<input type="submit" name="new_pswd" value="Modifier" />
	</p>
	</form>

  <p>Préférences :<br></p>
  <form action="account.php" method="post">
	<p>
		<input type="radio" name="preferences" value=1 checked>
     M'avertir par e-mail lorsque mes photos reçoivent un commentaire.<br>
    <input type="radio" name="preferences" value=0>
     Ne pas m'avertir.<br>
		<input type="submit" name="submit_preferences" value="Modifier" />
	</p>
	</form>
  <script src="scripts/pswd_lenght.js"></script>
	<?PHP
	$page_content = ob_get_clean();
}

/*Change password*/

if (isset($_POST['new_pswd']) && ($_POST['password'] == $_POST['password_confirm'])) {
	$old_pswd = htmlspecialchars($_POST['old_pswd']);
	$new_pswd = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
  $bdd = get_bdd();
  $query = $bdd->query('SELECT login, password FROM users');
  while ($current_line = $query->fetch()) {
    if ($current_line['login'] == $_SESSION['login'])
      $hash = $current_line['password'];
  }
  $query->closeCursor();
  if (password_verify($old_pswd, $new_pswd))
    $page_content = "<p>Ancien et nouveau mot de passe identiques.</p>";
  else if (password_verify($old_pswd, $hash)) {
    $bdd = get_bdd();
  	$sql = $bdd->prepare('UPDATE users SET password="'.$new_pswd.'" WHERE login="'.$_SESSION['login'].'"');
  	$sql->execute();
    $page_content = "<p>Mot de passe modifié avec succès.</p>";
  }
  else
    $page_content = "<p>Ancien mot de passe incorrect.</p>";
}

else if (isset($_POST['new_pswd']))
  $page_content = "<p>Les mots de passe fournis sont différents. Veuillez recommencer.</p>";

/*Change preferences*/

if (isset($_POST['submit_preferences'])) {
  $bdd = get_bdd();
  $sql = $bdd->prepare('UPDATE users SET alerts="'.$_POST['preferences'].'" WHERE login="'.$_SESSION['login'].'"');
  $sql->execute();
  $page_content = "<p>Préférences mises à jour avec succès.</p>";
}

if (!(isset($_SESSION['login']))) {
  ob_start(); ?>
  <p>Pour accéder à votre espace personnel, veuillez vous <a href="login.php">connecter</a>.<br></p>
  <?PHP
  $page_content = ob_get_clean();
}

  require 'gabarit.php'; ?>
