<?PHP

  require 'database.php';

  try {
		$bdd = new PDO($DB_DSN_BASE, $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE ".$DB_NAME."";
    $bdd->exec($sql);
    echo "Database ".$DB_NAME." successfully created\n";
  }
  catch (PDOException $e) {
    echo "Creating database ".$DB_NAME." failed :\n" .$e->getMessage(). "\nProcess aborted.\n";
  }

  try {
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      login VARCHAR(30) NOT NULL,
      password VARCHAR(255) NOT NULL,
      email VARCHAR(70),
      hash VARCHAR(255) NOT NULL,
      valid INT(1) NOT NULL DEFAULT '0',
      alerts INT(1) NOT NULL DEFAULT '1',
      signup_date TIMESTAMP)";
      $bdd->exec($sql);
      echo "Table users successfully created\n";
  }
  catch (PDOException $e) {
    echo "Creating table users failed :\n" .$e->getMessage(). "\nProcess aborted.\n";
  }

?>
