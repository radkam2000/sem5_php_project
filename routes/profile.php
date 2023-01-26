<?php
if (!isset($_SESSION['username'])){
	http_response_code(401); // Unauthorized access
	header('location: '.$root.'/');
	return;
}
?>

<p>Username: <?=$_SESSION['username']?></p>
<!-- <p><a href=<?//=$root."/changePassword"?>>Change password</a></p> -->
<p><a href=<?=$root."/deleteAccount"?>>Delete account</a></p>
