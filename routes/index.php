<?php $site['title'] .= ' - Home'; ?>
<?php
$site['style'][] = '
.home {
	margin-top: 5em;
	display: flex;
	flex-direction: column;
}
p{
	text-align: center;
}
';
?>
<div class="home">
<p>This is chatting app inspired by IRC (Internet Relay Chat - <a href="https://en.wikipedia.org/wiki/Internet_Relay_Chat">Wiki</a>) using html, php, js, and mysql database.</p>
<p><a href=<?=$root."/login"?>>Log in</a></p>
<p><a href=<?=$root."/register"?>>Sign Up</a></p>
</div>