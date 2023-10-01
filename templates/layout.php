<?php if (!isset($_SESSION)) {
	session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Primary Meta Tags -->
	<title><?= $title ?></title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />

	<meta name="title" content="I am Anørak - Home" />
	<meta name="description" content="This blog is a portfolio coded in Vanilla PHP. You'll find some of my projects and are able to register and comment. You can also visit my second portfolio https://iamseb.dev.
		hope you all enjoy :)" />
	<meta name="keywords" content="blog, portfolio, php, vanilla, javascript, html, css, bootstrap, sass, mysql, phpmyadmin, git, github, heroku, netlify, api, weather, ipgeoloc, mapbox, gsap, tweenmax">
	<meta name="author" content="Anørak">
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="7 days">
	<meta name="theme-color" content="#6ec6ff" />
	<meta name="msapplication-navbutton-color" content="#6ec6ff">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="#6ec6ff">


	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://xn--anrak-wua.dev/" />
	<meta property="og:title" content="I am Anørak - Home" />
	<meta property="og:description" content="This blog is a portfolio coded in Vanilla PHP. You'll find some of my projects and are able to register and comment. You can also visit my second portfolio https://iamseb.dev.
		hope you all enjoy :)" />
	<meta property="og:image" content="../public/img/metatagPicture.png" />

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:url" content="https://xn--anrak-wua.dev/" />
	<meta property="twitter:title" content="I am Anørak - Home" />
	<meta property="twitter:description" content="This blog is a portfolio coded in Vanilla PHP. You'll find some of my projects and are able to register and comment. You can also visit my second portfolio https://iamseb.dev.
		hope you all enjoy :)" />
	<meta property="twitter:image" content="../public/img/metatagPicture.png" />

	<script defer data-domain="xn--anrak-wua.dev" src="https://plausible.sebdevcloud.synology.me/js/script.file-downloads.js"></script>

	<link rel="stylesheet" href="../src/lib/style/style.css">
	<link rel="icon" type="image/x-icon" href="../public/favicon.ico">
	<script src="https://kit.fontawesome.com/89ed478db9.js" crossorigin="anonymous"></script>
	<script src="../src/lib/script/script.js" type="module"></script>

	<?php
	require_once __DIR__ . '../../config/config.local.php';
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
