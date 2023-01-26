<?php
if (isset($_SESSION['username'])) {
	Error('You are already logged in. You will be redirected in 5 seconds');
	http_response_code(307); // Temporary Redirect (Already logged in)
	header ('refresh: 5;URL='.$root.'/chat');
} else {


$data = filter_input_array(INPUT_POST, [
	'username' => [],
	'password' => [],
]);

if ($data) {
    try {
        $success = $db->getPassword->execute([
            'username' => $data['username'],
        ]);

        if (!$success) {
            Error('Incorrect credentials!');
        } else {
            $password = $db->getPassword->fetch(PDO::FETCH_ASSOC)['password'];
            
            if (password_verify($data['password'], $password)) {
                $_SESSION['username'] = $data['username'];
                
                http_response_code(307); // Temporary Redirect (Logged In)
                header('location: '.$root.'/chat');    
            } else {
                Error('Incorrect credentials!');
            }
        }
    } catch (Exception $e) { // Database Error
        Error($e->getMessage());
    }
}

$site['style'][] = '
p {
	margin-top: 0.25em;
	margin-bottom: 0.25em;
}

form.login {
	display: flex;
	flex-direction: column;
	max-width: 48rem;
	margin: 0 auto;
}

form.login input {
	padding: 1em;
	margin-bottom: 1em;
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border-width: 0;
}

form.login input:focus {
	outline: 1px solid white;
}

form.login button {
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border: 1px solid hsl(0, 0%, 50%);
	padding: 1em;
	margin-bottom: 1em;
	cursor: pointer;
}

form.login button:hover {
	border-color: hsl(0, 0%, 90%);
}

.text-center {
	text-align: center;
}

';
?>
<h1 class="text-center">Log in</h1>
<form class="login" method="POST">
	<p>Login</p>
    <input type="text" name="username" placeholder="Login" required />
	<p>Password</p>
    <input type="password" name="password" placeholder="Password" required />
    <button>Log in</button>
</form>
		<p class="text-center">Need an account? <a href=<?=$root."/register";?>>Sign up</a></p>
<?php
} 
?>