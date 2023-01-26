<?php

if (!isset($_SESSION['username'])){
	http_response_code(401); // Unauthorized access
	header('location: '.$root.'/');
	return;
}

if(isset($_GET['passwordChanged'])){
	Success("Password was successfully changed.");
}


$site['style'][] = '
.profile {
	display: flex;
	margin: auto;
	flex-direction: column;
	align-items: center;
}
'
?>
<div class="profile">
	<p>[Username] <?=$_SESSION['username']?></p>
	<p><a href=<?=$root."/changePassword"?>>Change password</a></p>
	<p><a href=<?=$root."/deleteAccount"?>>Delete account</a></p>
</div>