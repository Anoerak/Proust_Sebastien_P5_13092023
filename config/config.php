<?php

// We define our database connection constants
// WINDOWS
// define('DB_HOST', 'your-db-urk');
// define('DB_PORT', 'port');
// MAC
define('DB_HOST', 'your-db-urk');
define('DB_PORT', 'port');
define('DB_NAME', 'db-name');
define('DB_USER', 'db-user');
define('DB_PASSWORD', 'db-password');

// We define our variable
define('IPGEOLOC_API_KEY', 'your-api-key');
define('WEATHERAPI_API_KEY', 'your-api-key');

// We define our resources array
define(
	'RESOURCES',
	[
		'contact' => [
			'<link rel="stylesheet" href="../templates/contact/contact.css">',
		],
		'blog' => [
			'<script defer src="../templates/blog/blog.js" type="module"></script>',
			'<link rel="stylesheet" href="../templates/blog/blog.css">',
		],
		'about' => [
			'<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></>',
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>',
			'<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ModifiersPlugin.min.js"></script>',
			'<script defer src="../templates/about/about.js" type="module"></script>',
			'<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="../templates/about/about.css">'
		],
		'privacyPolicy' => [
			'<link rel="stylesheet" href="../templates/privacyPolicy/privacyPolicy.css">',
		],
		'login' => [
			'<link rel="stylesheet" href="../templates/login/login.css">',
		],
		'signup' => [
			'<link rel="stylesheet" href="../templates/signup/signup.css">',
		],
		'userProfile' => [
			'<link rel="stylesheet" href="../templates/userProfile/userProfile.css">',
		],
		'post' => [
			'<link rel="stylesheet" href="../templates/post/postView.css">',
			'<link rel="stylesheet" href="../templates/post/postAdd.css">',
			'<link rel="stylesheet" href="../templates/post/postUpdate.css">',
			'<link rel="stylesheet" href="../templates/comment/comment.css">',
			'<link rel="stylesheet" href="../templates/comment/commentAdd.css">',
		],
		'loading' => [
			'<link rel="stylesheet" href="../templates/loading/loading.css">',
		],
		'error' => [
			'<link rel="stylesheet" href="../templates/error/error.css">',
		],
	]
);
