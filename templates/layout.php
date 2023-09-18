<?php if (!isset($_SESSION)) {
	session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= $title ?></title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/89ed478db9.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../src/lib/style/style.css">

	<?php
	require_once __DIR__ . '/../config/config.local.php';
	if (isset($_GET['page']) && array_key_exists($_GET['page'], RESOURCES)) {
		foreach (RESOURCES[$_GET['page']] as $resource) {
			echo $resource;
		}
	}
	?>

</head>

<body>
	<?php require 'templates/components/header/header.php'; ?>
	<main>
		<?= $content ?>
		<!-- Élément spécifique -->
	</main>
	<?php include 'templates/components/footer/footer.php'; ?>
</body>


</html>