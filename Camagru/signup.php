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

else if (isset ($_POST['signup'])) {
	$login = htmlspecialchars($_POST['login']);
	//$password = salt_password($_POST['password']);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$email = $_POST['email'];
	$rand = rand(1000, 5000);
	$hash = password_hash($rand, PASSWORD_DEFAULT);

	$bdd = get_bdd();
	$sql = $bdd->prepare('INSERT INTO users (login, password, email, hash, date)
				VALUES ("'.$login.'", "'.$password.'", "'.$email.'", "'.$hash.'", NOW())');
	$sql->execute();
	send_email($login, $email, $hash);
	ob_start(); ?>
	<p>Veuillez cliquer sur le lien de confirmation que vous allez recevoir
	à l'adresse e-mail fournie.</p>
	<?PHP
	$page_content = ob_get_clean();
}

else {
	ob_start(); ?>
	<form action="signup.php" method="post">
	<p>
		<label for "name">Nom d'utilisateur :</label> <input type="text" name="login" /><br>
		<label for "password">Mot de passe :</label> <input type="password" name="password" value="Mot de passe"
		onfocus="if (this.value=='Mot de passe') this.value='';"
		onblur="if(this.value == ''){this.value='Mot de passe';}" /><br>
		<label for "email">Adresse mail :</label> <input type="email" name="email" value="exemple@camagru.fr"
		onfocus="if (this.value=='exemple@camagru.fr') this.value='';"
		onblur="if(this.value == ''){this.value='exemple@camagru.fr';}" /><br>
		<input type="submit" name="signup" value="Créer mon compte" />
	</p>
	</form>
	<?PHP
	$page_content = ob_get_clean();
}

require 'gabarit.php'; ?>
