<?php if (!isset($_SESSION)) {
	session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://kit.fontawesome.com/89ed478db9.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="../src/lib/style/style.css">

	<?php
	if ($title === "IamSeb - About") {
		echo '
			<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ModifiersPlugin.min.js"></script>
			<script defer src="../templates/about/about.js" type="module"></script>
			<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />
		';
	} ?>

	<title><?= $title ?></title>
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