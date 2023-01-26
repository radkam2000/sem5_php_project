<?php

$site['style'][] = '
p.success {
	background-color: hsla(120, 50%, 20%);
	color: hsl(120, 50%, 90%);
	padding: 1em;
}
';

?>
<?php function Success($message = '') { ?>
<p class="success"><?= htmlspecialchars($message) ?></p>
<?php } ?>
