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

$data = [
	'message' => file_get_contents('php://input'), // Read HTTP raw payload
];

if ($data['message'] === '') {
	http_response_code(400); // Bad Request
	
	die(json_encode([
		'error' => 'Message cannot be empty.',
	]));
}

if (strlen($data['message']) > 1024) {
	http_response_code(400); // Bad Request
	
	die(json_encode([
		'error' => 'Message can hold up to 1024 characters.',
	]));
}

try {
	$success = $db->sendMessage->execute([
		'username' => $_SESSION['username'],
		'message' => $data['message'],
	]);
	
	if (!$success) {
		http_response_code(500); // Internal Server Error
		
		die(json_encode([
			'error' => 'Database error.',
		]));
	}
} catch (Exception $e) {
	http_response_code(500); // Internal Server Error
	
	die(json_encode([
		'error' => $e->getMessage(),
	]));
}

die(json_encode([
	'id' => $db->pdo->lastInsertId(),
]));

?>