<!DOCTYPE html>
<<html>
<head>
	<title>Confirm sign up</title>
</head>
<body>
	<h1>Thanks for regestration!</h1>
	<p>
		Please click on the link below to complete the registration: <br>
		<a href="{{ route('confirm_email'), $user->activation_token }}">
			{{ route('confirm_email', $user->activation_token) }}
		</a>
	</p>
	<p>
		If this is not your own operation, please ignore this message.
	</p>
</body>
</html>