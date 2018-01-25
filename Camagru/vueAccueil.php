<!-- Vue : presentation a l'utilisateur, saisie et validation des donnees //-->

<?PHP $page_title = 'Accueil';
ob_start(); //enclenche la mise en tampon
/*foreach ($users as $user)
	echo ($user['name'] . " " . $user['date_inscription'] . "\n");
echo "OK7\n";*/
foreach ($photos as $photo): ?>
	<article>
		<header>
			<a href="<?= "photo.php?id=" . $photo['id'] ?>">
				<h1 class="photo_title"><?= $photo['titre'] ?></h1>
			</a>
			<time><?= $photo['date'] ?></time>
		</header>
		<p><?= $photo['image'] ?></p>
	</article>
	<hr />
<?PHP endforeach;
$page_content = ob_get_clean(); //efface le contenu du tampon
require 'gabarit.php'; ?>
