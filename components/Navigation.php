<?php function Navigation() { ?>
<?php

global $root;

$active = function($path) {
	global $route;

	return $route == $path ? 'data-active' : '';
};

$paths = [];

$loggedInPaths = [
	'/chat'	 => 'Chat',
	'/profile'	=> 'Profile',
	'/logout' => 'Log out',
];

if (isset($_SESSION['username'])) {
	$paths = $loggedInPaths;
}

?>
<nav>
	<ul>
<?php foreach ($paths as $path => $name) { ?>
		<li><a href="<?= htmlspecialchars($root.$path) ?>" <?= $active($path) ?>><?= htmlspecialchars($name) ?></a></li>
<?php } ?>
	</ul>
</nav>
<?php } ?>
