<?PHP $page_title = "Camagru - " . $photo['titre'];
ob_start(); ?>
<article>
  <header>
    <h1 class="photo_title"><?= $photo['titre'] ?></h1>
    <time><?= $photo['date'] ?></time>
  </header>
  <p><?= $photo['image'] ?></p>
</article>
<hr />
<header>
  <h1 id="comments_title">Commentaires à <?= $photo['titre'] ?></h1>
</header>
<?PHP foreach ($comments as $comment): ?>
  <p><?= $comment['auteur'] ?> dit :</p>
  <p><?= $comment['commentaire'] ?></p>
<?PHP endforeach;
$page_content = ob_get_clean();
require 'gabarit.php'; ?>
