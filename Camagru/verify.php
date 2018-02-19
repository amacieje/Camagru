<?PHP
require 'Modele.php';
$page_title = 'Compte activé';


if (isset($_GET['email']) && !empty($_GET['email'])
    AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email = $_GET['email'];
    $hash = $_GET['hash'];
    $bdd = get_bdd();
  	$sql = $bdd->prepare("SELECT email, hash, valid FROM users
      WHERE email='".$email."' AND hash='".$hash."' AND valid='0'");
  	$sql->execute();
    $match = $sql->rowCount();
    if ($match > 0) {
      $sql = $bdd->prepare("UPDATE users SET valid='1' WHERE email='".$email."'");
      $sql->execute();
      $page_content = "<br>Merci, votre compte est à présent actif.<br>
      Vous pouvez vous <a href='http://localhost:8080/Camagru/login.php'>connecter</a>.";
    }
    else {
      $page_content = "<br>URL invalide ou compte déjà activé.<br>
      Vous pouvez essayer de vous <a href='http://localhost:8080/Camagru/login.php'>connecter</a>."; }
}

else {
  $page_content = "<br>Approche invalide, veuillez utiliser le lien envoyé à l'adresse e-mail
  fournie lors de votre inscription."; }

require 'gabarit.php';
