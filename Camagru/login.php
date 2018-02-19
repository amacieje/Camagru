<?PHP
  session_start();
  require 'Modele.php';
  $page_title = 'Connexion';

if (isset($_POST['forgot_password'])) {
  $email = strtolower(htmlspecialchars($_POST['email']));
  $bdd = get_bdd();
  $query = $bdd->query('SELECT login, hash, email, valid FROM users');
  while ($current_line = $query->fetch()) {
    if ($current_line['email'] == $email && $current_line['valid'] == '1') {
      $hash = $current_line['hash'];
      $login = $current_line['login'];
    }
  }
  $query->closeCursor();
  if (isset($hash)) {
    send_forgotten_pswd_email($login, $email, $hash);
    $page_content = "<p>Afin de changer votre mot de passe, veuillez cliquer
    sur le lien de confirmation que vous allez recevoir à l'adresse e-mail fournie.</p>";
  }
  else {
    $page_content = "<p>Erreur : vous n'êtes pas encore inscrit ou vous n'avez pas activé votre compte.<br>
    Cliquez <a href='signup.php'>ici</a> pour vous inscrire ou vérifiez vos e-mails.</p>";
  }
}

else if (isset($_SESSION['login'])) {
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
      <button type="button" onclick="document.getElementById('forgot_password').style.display='block'">Mot de passe oublié</button>
    </p>
  </form>

  <div id="forgot_password">
    <form action="login.php" method="post">
    <label for="email">Mon adresse e-mail : </label>
    <input id="email" type="email" name="email"
    pattern="[a-z0-9A-Z._%+-]+@[a-z0-9A-Z.-]+\.[a-zA-Z]{2,3}$"
    title="Veuillez entrer une adresse email de format 'exemple@camagru.fr'." required/><br>
    <input type="submit" name="forgot_password" value="M'envoyer un e-mail pour changer mon mot de passe" />
    </form>
  </div>

  <?PHP
  $page_content = ob_get_clean();
}

  require 'gabarit.php'; ?>
