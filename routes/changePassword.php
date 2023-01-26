<?php

if (!isset($_SESSION['username'])){
	http_response_code(401); // Unauthorized access
	header('location: '.$root.'/');
    return;
}

$data = filter_input_array(INPUT_POST, [
    'new_password' => [],
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
                    $db->changePassword->execute([
                        'password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                        'username' => $_SESSION['username'],
                    ]);
				} else {
					Error('Incorrect password!');
				}
			}
		} catch (Exception $e) { // Database Error
			Error($e->getMessage());
		} finally{
			http_response_code(307); // Temporary Redirect (Password changed)
			header ('location: '.$root.'/profile?passwordChanged=1');
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
<h1 class="text-center">Change your password</h1>
<form class="deleteAccount" method="POST">

    <p>New Password</p>
	<input type="password" name="new_password" placeholder="Password" required />
	<p>Current Password</p>
	<input type="password" name="password" placeholder="Password" required />
	<p>Repeat Current Password</p>
	<input type="password" name="password2" placeholder="Password" required />
	<button>Confirm</button>
</form>