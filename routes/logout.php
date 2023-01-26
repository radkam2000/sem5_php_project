<?php

if (isset($_SESSION['username'])) {
	$_SESSION = []; // Clear the entire session without resetting PHPSESSID
	Error('You were successfully logged out.');	
	http_response_code(307); // Temporary Redirect (Logged out)
	header('location: '.$root.'/login');
} else {
	http_response_code(307); // Temporary Redirect (Home page)
    header('location: '.$root.'/');
	return;
}

?>
