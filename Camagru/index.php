<!-- Controller : recoit et interprete les requetes de l'utilisateur (ex : HTTP) //-->

<?PHP

	require 'Modele.php';
	try {
		$users = get_photos();
		require 'vueAccueil.php';
	}
	catch (PDOException $e) {
		$msgErreur = $e->getMessage();
		require 'vueErreur.php';
	}
