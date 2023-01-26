<?php

$site['style'][] = '
p.error {
	background-color: hsl(0, 50%, 20%);
	color: hsl(0, 50%, 90%);
	padding: 1em;
}
';

?>
<?php function Error($message = '') { ?>
<p class="error"><?= htmlspecialchars($message) ?></p>
<?php } ?>
