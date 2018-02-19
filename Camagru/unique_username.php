<?PHP
    header("Content-Type: text/xml");
    $page_title = 'Inscription';

    function get_bdd() {
  		require 'config/database.php';
  		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  		return $bdd;
  	}

    if (isset($_GET['name'])) {
      $bdd = get_bdd();
      $query = $bdd->query('SELECT login FROM users');
      while ($current_line = $query->fetch()) {
        if (strtolower($current_line['login']) == htmlspecialchars(strtolower($_GET['name'])))
          echo "Username already exists";
      }
      $query->closeCursor();
    }
?>
