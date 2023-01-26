<?php

if (isset($_SESSION['username'])) {
	Error('You are already logged in. ');
	http_response_code(307); // Temporary Redirect (Already logged in)
	header ('location: '.$root.'/chat');
} else {

$data = filter_input_array(INPUT_POST, [
	'username' => [],
	'password' => [],
	'password2' => [],
]);

if ($data) {
	if ($data['password'] !== $data['password2']) {
		Error('Passwords are not the same.');
	} else if (strlen($data['password']) < 8) {
		Error('Password must contain at least 8 characters.');
	} else if (strlen($data['username']) < 1) {
		Error('Login must contain at least 1 character.');
	} else if (strlen($data['username']) > 25) {
		Error('Login must contain maximum 25 characters.');
	} else {
		try {
			$success = $db->register->execute([
				'username' => $data['username'],
				'password' => password_hash($data['password'], PASSWORD_DEFAULT),
			]);

			if (!$success) {
				Error('This account already exists.');
			} else {
				$_SESSION['username'] = $data['username'];
				Success("Your account was succesfully created. You will be redirected in a few seconds");
				http_response_code(307); // Temporary Redirect (Logged In)
				header('location: '.$root.'/chat');
			}
		} catch (Exception $e) { // Database Error
			if($e->getCode()==='23000'){
					var_dump($e);
				Error("This account already exists.");
			} else {
					Error($e->getMessage());
			}
		}
	}
}

$site['style'][] = '
p {
	margin-top: 0.25em;
	margin-bottom: 0.25em;
}

form.register {
	display: flex;
	flex-direction: column;
	max-width: 48rem;
	margin: 0 auto;
}

form.register input {
	padding: 1em;
	margin-bottom: 1em;
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border-width: 0;
}

form.register input:focus {
	outline: 1px solid white;
}

form.register button {
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border: 1px solid hsl(0, 0%, 50%);
	padding: 1em;
	margin-bottom: 1em;
	cursor: pointer;
}

form.register button:hover {
	border-color: hsl(0, 0%, 90%);
}

.text-center {
	text-align: center;
}
';

?>
<h1 class="text-center">Register</h1>
<form class="register" method="POST">
	<p>Login</p>
	<input type="text" name="username" placeholder="Login" minlength="1" maxlength="25" title="Login must be between 1 and 25 characters." required autofocus />
	<p>Password</p>
	<input type="password" name="password" placeholder="Password" minlength="8" title="Password must contain at least 8 characters." required />
	<p>Repeat Password</p>
	<input type="password" name="password2" placeholder="Repeat Password" minlength="8" title="Password must contain at least 8 characters." required />
	<button>Register</button>
	<!-- <button type="button" onclick="document.forms[0].submit()">Register without client validation</button> -->
</form>
<p class="text-center">Already have an account? <a href=<?=$root."/login"?>>Log in</a></p>
<?php } ?>