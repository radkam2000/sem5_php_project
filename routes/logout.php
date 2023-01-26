<?php

if (isset($_SESSION['username'])) {
	$_SESSION = []; // Clear the entire session without resetting PHPSESSID
	Error('You were successfully logged out. You will be redirected in a few seconds');	
	http_response_code(307); // Temporary Redirect (Logged out)
	header ('refresh: 5;URL='.$root.'/');
} else {
	http_response_code(307); // Temporary Redirect (Home page)
	header('location: '.$root.'/');
	return;
}

?>
