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

//direct access to a non exisiting element results in a warning
$last_update_time = filter_var_array($_SESSION, [ 
	'last_update_time' => [],
])['last_update_time'];

$sync = isset($_GET['sync']) && $last_update_time;
$statement = $sync ? $db->historyAfter : $db->history;

try {
	$db->now->execute();
	
	$now = $db->now->fetch(PDO::FETCH_ASSOC)['now(3)'];
	
	$success = $statement->execute($sync ? [ 'time' => $last_update_time ] : []);
	
	$_SESSION['last_update_time'] = $now;
	
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

die(json_encode($statement->fetchAll(PDO::FETCH_ASSOC)));
?>