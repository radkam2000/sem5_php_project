<?php

if (!isset($_SESSION['username'])){
	http_response_code(401); // Unauthorized access
	header('location: '.$root.'/');
	return;
}

$data = filter_input_array(INPUT_POST, [
	'password' => [],
	'password2' => [],
]);

if ($data) {
	if ($data['password'] !== $data['password2']) {
		Error('Passwords are not the same.');
	} else {
		try {
			$success = $db->getPassword->execute([
				'username' => $_SESSION['username'],
			]);

			if (!$success) {
				Error('Incorrect password!');
			} else {
				$password = $db->getPassword->fetch(PDO::FETCH_ASSOC)['password'];
				
				if (password_verify($data['password'], $password)) {
					$db->deleteAccount->execute(['username' => $_SESSION['username']]);
					$db->chatDeleteAccount->execute(['username' => $_SESSION['username']]);
					$_SESSION = [];
                    Success("Your account was succesfully deleted.");
                    http_response_code(307); // Temporary Redirect (Account deleted)
                    header ('location: '.$root.'/?delete=1');
				} else {
					Error('Incorrect password!');
				}
			}
		} catch (Exception $e) { // Database Error
			Error($e->getMessage());
		}	
    }
}

$site['style'][] = '
p {
	margin-top: 0.25em;
	margin-bottom: 0.25em;
}

form.deleteAccount {
	display: flex;
	flex-direction: column;
	max-width: 48rem;
	margin: 0 auto;
}

form.deleteAccount input {
	padding: 1em;
	margin-bottom: 1em;
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border-width: 0;
}

form.deleteAccount input:focus {
	outline: 1px solid white;
}

form.deleteAccount button {
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border: 1px solid hsl(0, 0%, 50%);
	padding: 1em;
	margin-bottom: 1em;
	cursor: pointer;
}

form.deleteAccount button:hover {
	border-color: hsl(0, 0%, 90%);
}

.text-center {
	text-align: center;
}

';
?>
<h1 class="text-center">Verify your password to delete your account</h1>
<form class="deleteAccount" method="POST">
	<p>Password</p>
	<input type="password" name="password" placeholder="Password" required />
	<p>Repeat Password</p>
	<input type="password" name="password2" placeholder="Password" required />
	<button>Confirm</button>
</form>