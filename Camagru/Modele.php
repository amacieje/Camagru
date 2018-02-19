<!-- Modèle : acces aux donnees, fonctions, classes... //-->

<?PHP
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

	function get_bdd() {
		require 'config/database.php';
		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $bdd;
	}

	function get_photos() {
		$bdd = get_bdd();
		$users = $bdd->query('SELECT id, login as name, date as date_inscription FROM users');
		return $users;
	}

	function get_photo($id_photo) {
		$bdd = get_bdd();
		$photo = $bdd->prepare('select PHOTO_ID as id, PHOTO_DATE as date,'
		. ' PHOTO_TITLE as titre, PHOTO_CONTENT as image from T_PHOTOS'
		. ' where PHOTO_ID=?');
		$photo->execute(array($id_photo));
		if ($photo->rowCount() > 0) //Un PDOStatement qui retourne le nb de lignes affectées par le dernier appel à execute
			return $photo->fetch(); //Accès à la première ligne de résultat
		else
			throw new Exception("Aucune photo ne correspond à l'identifiant '$id_photo'");
	}

	function get_comments($id_photo) {
		$bdd = get_bdd();
		$comments = $bdd->prepare('select COM_ID as id, COM_DATE as date,'
		. ' COM_AUTHOR as auteur, COM_CONTENT as commentaire from T_COMMENTS'
		. ' where PHOTO_ID=?');
		$comments->execute(array($id_photo));
		return $comments;
	}


	function send_email($login, $email, $hash) {
		$subject = 'Camagru - Vérification de l\'adresse mail';
		$message = 'Bienvenue '.$login.' !<br>

		Merci pour votre inscription à la communauté du Camagru !<br>
		Afin de valider votre compte, veuillez cliquer
		<a href="http://localhost:8080/Camagru/verify.php?email='.$email.'&hash='.$hash.'">ICI</a>.<br>
		A tout de suite sur Camagru !<br>

		';
		$headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'from:noreplay@camagru.fr' . "\r\n";
		mail($email, $subject, $message, $headers);
	}

	function send_forgotten_pswd_email($login, $email, $hash) {
		$subject = 'Camagru - Réinitialiser mon mot de passe';
		$message = ''.$login.',<br>

		Nous avons reçu une demande de réinitialisation de votre mot de passe.<br>
		Si vous êtes bien à l\'origine de cette demande, veuillez cliquer
		<a href="http://localhost:8080/Camagru/forget_pswd.php?email='.$email.'&hash='.$hash.'&change_pswd=1">ICI</a>
		pour le modifier.<br>
		A tout de suite sur Camagru !<br>

		';
		$headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'from:noreplay@camagru.fr' . "\r\n";
		mail($email, $subject, $message, $headers);
	}
