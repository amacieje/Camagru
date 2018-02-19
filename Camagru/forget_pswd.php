<?PHP
session_start();
require 'Modele.php';
$page_title = 'Réinitiliser mon mot de passe';

if (isset($_GET['email']) && !empty($_GET['email'])
    AND isset($_GET['hash']) && !empty($_GET['hash'])
    AND isset($_GET['change_pswd'])) {

    $email = $_GET['email'];
    $hash = $_GET['hash'];

    $bdd = get_bdd();
    $query = $bdd->query("SELECT login, email, hash FROM users
    WHERE email='".$email."' AND hash='".$hash."'");
    $current_line = $query->fetch();
    $_SESSION['email'] = $current_line['email'];
    ob_start(); ?>

      <p>Réinitialiser mon mot de passe :<br></p>
      <form action="forget_pswd.php" method="post">
      <p>
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
      <script src="scripts/pswd_lenght.js"></script>

    <?php
    $page_content = ob_get_clean();
}

else if (isset($_POST['new_pswd']) && ($_POST['password'] == $_POST['password_confirm'])) {
	$new_pswd = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
  $bdd = get_bdd();
	$sql = $bdd->prepare('UPDATE users SET password="'.$new_pswd.'" WHERE email="'.$_SESSION['email'].'"');
	$sql->execute();
  $page_content = "<p>Mot de passe modifié avec succès.<br>
  Vous pouvez vous <a href='http://localhost:8080/Camagru/login.php'>connecter</a>.</p>";
}

else if (isset($_POST['new_pswd']))
  $page_content = "<p>Les mots de passe fournis sont différents. Veuillez recommencer.</p>";

else
    $page_content = "<br>URL invalide. Veuillez cliquer sur le lien reçu par mail.";

require 'gabarit.php';
