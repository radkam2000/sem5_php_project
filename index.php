<?php

$site = [
	'title' => '',
	'style' => [],
	'stylesheet' => [],
	'icon' => '',
	'meta' => [
		'viewport' => 'width=device-width',
	],
	'lang' => 'en',
];

$routes = [
	'/'			=> 'index.php',
	'/register'	=> 'register.php',
	'/logout'	=> 'logout.php',
	'/login'	=> 'login.php',
	'/chat'		=> 'chat.php',
	'/deleteAccount' => 'deleteAccount.php',
	'/profile'	=>	'profile.php',
	'/changePassword' => 'changePassword.php',
];

// $root can be an empty string if the project is located at document root
$root = substr(
	dirname(
		$_SERVER['SCRIPT_FILENAME']
	),
	strlen(
		$_SERVER['DOCUMENT_ROOT']
	),
);

// $route is relative to $root, always starts with /
$route = substr(
	strtok($_SERVER['REQUEST_URI'], '?'),
	strlen($root),
);

session_start();

include_once('Database.php');

$db = DB::get();

(function() {
	global $site;

	$components = glob('components/*.php');

	foreach ($components as $component) {
		include_once($component);
	}
})();

$content = function() {
	global $site;
	global $routes;
	global $route;
	global $root;
	global $db;

	$route_filename = '404.php';

	if (isset($routes[$route])) {
		$route_filename = 'routes/'.$routes[$route];

		if (!file_exists($route_filename)) {
			$route_filename = '404.php';
		}
	} else {
		$route_filename = '404.php';
	}

	ob_start();

	include_once($route_filename);

	return ob_get_clean();
};

ob_start();

include_once('layout.php');

$content = ob_get_clean();

if (isset(headers_list()['location'])) {
	// Redirection, no need to render.
	die();
}

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($site['lang']) ?>">
<head>
	<title><?= htmlspecialchars($site['title']) ?></title>
<?php foreach ($site['meta'] as $key => $value) { ?>
	<meta name="<?= htmlspecialchars($key) ?>" content="<?= htmlspecialchars($value) ?>" />
<?php } ?>
<?php foreach ($site['stylesheet'] as $stylesheet) { ?>
	<link rel="stylesheet" href="<?= htmlspecialchars($stylesheet) ?>">
<?php } ?>
<?php if ($site['icon']) { ?>
	<link rel="icon" href="<?= htmlspecialchars($site['icon']) ?>">
<?php } ?>
<?php foreach ($site['style'] as $style) { ?>
	<style>
<?= /* do not htmlspecialchars because > is a valid CSS character */ $style ?>
	</style>
<?php } ?>
</head>
<body>
<?= $content ?>
</body>
</html>
