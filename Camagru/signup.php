<?PHP
	session_start();
	require 'Modele.php';
	$page_title = 'Inscription';

if (isset($_SESSION['login'])) {
	ob_start(); ?>
	<p>Vous êtes connecté(e) en tant que <?PHP echo $_SESSION['login']; ?>. <br>
		Pour créer un nouveu compte, veuillez vous déconnecter.</p>
	<?PHP
	$page_content = ob_get_clean();
}

else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$login = htmlspecialchars($_POST['login']);
	$password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
	$password_confirm = password_hash(htmlspecialchars($_POST['password_confirm']), PASSWORD_DEFAULT);
	$email = strtolower(htmlspecialchars($_POST['email']));
	$rand = rand(1000, 5000);
	$hash = password_hash($rand, PASSWORD_DEFAULT);

	if ($_POST['password'] == $_POST['password_confirm']) {
		$bdd = get_bdd();
		$sql = $bdd->prepare('INSERT INTO users (login, password, email, hash, signup_date)
					VALUES ("'.$login.'", "'.$password.'", "'.$email.'", "'.$hash.'", NOW())');
		$sql->execute();
		send_email($login, $email, $hash);
		$page_content = "<p>Afin de finaliser votre inscription, veuillez cliquer
		sur le lien de confirmation que vous allez recevoir à l'adresse e-mail fournie.</p>";
	}
	else
		$page_content = "<p>Les mots de passe fournis sont différents. Veuillez recommencer.</p>";
}

else {
	ob_start(); ?>
	<form method="post">
	<p>
		<label for="name">Nom d'utilisateur :</label>
		<input id="username" type="text" name="login" required />

		<div id="valid_username">
      <p class="already_exists">Oups, ce nom d'utilisateur est déjà pris !</p>
    </div>

		<label for="password">Mot de passe :</label>
		<input id="psw" type="password" name="password"
		pattern=".{8,}" title="Veuillez choisir un mot de passe d'une longueur minimale de 8 carctères." required/><br>

    <div id="message">
      <p id="length" class="invalid">Mot de passe d'une longueur minimale de <b>8 caractères</b>.</p>
    </div>

		<br><label for="password">Confirmer le mot de passe :</label>
		<input type="password" name="password_confirm" required/><br><br>

		<label for="email">Adresse mail :</label>
		<input id="email" type="email" name="email"
		pattern="[a-z0-9A-Z._%+-]+@[a-z0-9A-Z.-]+\.[a-zA-Z]{2,3}$"
		title="Veuillez entrer une adresse email de format 'exemple@camagru.fr'." required/><br>

		<div id="unique_email">
			<p class="already_exists">Un compte a déjà été crée avec cette adresse. <a href="login.php">Se connecter</a>.</p>
		</div>
		<div id="email_pattern">
			<p class="already_exists">Veuillez entrer un email valide.</p>
		</div>

		<br>
		<input id="signup_button" type="submit" name="signup" value="Créer mon compte" disabled
		onclick="this.disabled=true;this.form.submit();" />
	</p>
	</form>
	<script>
		var check_username = 0;
		var check_password = 0;
		var check_email = 0;
	</script>
	<script src="scripts/unique_username.js"></script>
	<script src="scripts/pswd_lenght.js"></script>
	<script src="scripts/unique_email.js"></script>

	<?PHP
	$page_content = ob_get_clean();
}

require 'gabarit.php'; ?>
