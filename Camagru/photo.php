<?PHP

require 'Modele.php';

try {
  if (isset($_GET['id'])) {
    $id = intval($_GET['id']); //intval retourne la valeur numérique entière de son paramètre et 0 en cas d'échec
    if ($id != 0) {
      $photo = get_photo($id);
      $comments = get_comments($id);
      require 'vuePhoto.php';
    }
    else
      throw new Exception("Identifiant photo incorrect");
  }
  else
    throw new Exception("Aucun identifiant de photo");
}
catch (Exception $e) {
  $msgErreur = $e->getMessage();
  require 'vueErreur.php';
}
