<?php 

if(isset($_GET['delete'])){
    Success('Your account was successfully deleted.');
}

if(isset($_GET['logout'])){
    Success('You were sucessfully logged out.');
}

$site['title'] .= ' - Home';

$site['style'][] = '
.home {
	margin-top: 5em;
	display: flex;
	flex-direction: column;
}
p {
	text-align: center;
}
';
?>

<div class="home">
<p>This is chatting app inspired by IRC (Internet Relay Chat - <a href="https://en.wikipedia.org/wiki/Internet_Relay_Chat">Wiki</a>) using html, php, js, and mysql database.</p>
<p><a href=<?=$root."/login"?>>Log in</a></p>
<p><a href=<?=$root."/register"?>>Sign Up</a></p>
</div>