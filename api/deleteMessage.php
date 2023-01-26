<?php

header('content-type: application/json');

session_start();

if (!isset($_SESSION['username'])) {
	http_response_code(401); // Unauthorized
	
	die(json_encode([
		'error' => 'Not logged in.',
	]));
}

include_once('../Database.php');

$db = DB::get();

$id = filter_input(INPUT_GET, 'id');

try {
	$success = $db->markAsDeleted->execute([ 'id' => $id, 'username' => $_SESSION['username'] ]);
	
	if (!$success) {
		http_response_code(403); // Forbidden
		
		die(json_encode([
			'error' => 'Forbidden!',
		]));
	}
} catch (Exception $e) {
	http_response_code(500); // Internal Server Error
	
	die(json_encode([
		'error' => $e->getMessage(),
	]));
}

die(json_encode((object) []));
?>