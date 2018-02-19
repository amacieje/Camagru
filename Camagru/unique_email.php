<?PHP
    header("Content-Type: text/xml");
    $page_title = 'Inscription';

    function get_bdd() {
  		require 'config/database.php';
  		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  		return $bdd;
  	}

    if (isset($_GET['email'])) {
      $bdd = get_bdd();
      $query = $bdd->query('SELECT email FROM users');
      while ($current_line = $query->fetch()) {
        if ($current_line['email'] == htmlspecialchars(strtolower($_GET['email'])))
          echo "Email already exists";
      }
      $query->closeCursor();
    }
?>
