<!-- Cookie à set avant tout code HTML, donc pas ici -->

<?PHP
setcookie(login, $_POST['login'], time() + 90*24*3600, null, null, false, true);
if isset($_COOKIE['login'])
	echo htmlspecialchars($_COOKIE['login']);
else
	echo "NO";?>
