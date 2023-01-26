<?php 
$site['stylesheet'][] = $root.'/public/main.css';
$site['icon'] = $root.'/public/favicon.png';
$site['title'] = 'Chatter';
?>
<?php Navigation(); ?>
<main>
<?= $content() ?>
</main>
<?php Footer(); ?>
