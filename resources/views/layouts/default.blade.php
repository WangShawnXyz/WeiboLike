<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title','Myweb App') - Learn Laravel</title>
		<link rel="stylesheet" type="text/css" href="/css/app.css">
	</head>
	<body>
		@include('layouts._header')
		<div class="container">
			<div class="col-md-offset-1 col-md-10">
				@include('shared.messages')
				@yield('content')
				@include('layouts._footer')
			</div>
		</div>
	</body>
</html>