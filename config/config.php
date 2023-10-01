<?php

// We define our database connection constants
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
			'<link rel="stylesheet" href="../templates/pages/contact/contact.css">',
		],
		'blog' => [
			'<script defer src="../templates/pages/blog/blog.js" type="module"></script>',
			'<link rel="stylesheet" href="../templates/pages/blog/blog.css">',
		],
		'about' => [
			'<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="../templates/pages/about/about.css">',
			'<script 
				defer 
				src="../templates/pages/about/about.js" 
				type="module"
			>
			</script>',
			'<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>',
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>',
			'<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ModifiersPlugin.min.js"></script>',
		],
		'privacyPolicy' => [
			'<link rel="stylesheet" href="../templates/pages/privacyPolicy/privacyPolicy.css">',
		],
		'login' => [
			'<link rel="stylesheet" href="../templates/pages/login/login.css">',
		],
		'signup' => [
			'<link rel="stylesheet" href="../templates/pages/signup/signup.css">',
		],
		'userProfile' => [
			'<link rel="stylesheet" href="../templates/pages/userProfile/userProfile.css">',
		],
		'post' => [
			'<link rel="stylesheet" href="../templates/pages/post/postView.css">',
			'<link rel="stylesheet" href="../templates/pages/post/postAdd.css">',
			'<link rel="stylesheet" href="../templates/pages/post/postUpdate.css">',
			'<link rel="stylesheet" href="../templates/pages/comment/comment.css">',
			'<link rel="stylesheet" href="../templates/pages/comment/commentAdd.css">',
		],
		'rules' => [
			'<link rel="stylesheet" href="../templates/pages/rules/rules.css">',
		],
		'subscribe' => [
			'<link rel="stylesheet" href="../templates/pages/subscribe/subscribe.css">',
		],
	]
);
