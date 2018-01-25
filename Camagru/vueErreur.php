<?PHP $page_title = 'Error';
ob_start(); ?>
<p>Une erreur est survenue : <?= $msgErreur ?></p>
<?PHP $page_content = ob_get_clean();
require 'gabarit.php'; ?>
