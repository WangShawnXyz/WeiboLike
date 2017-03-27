@extends('layouts.default')
@section('title', 'Home')
@section('content')
	<div class="jumbotron">
		<h1>Hello Laravel!</h1>
		<p class="lead">
			This is the home page of Learn Laravel!
		</p>
		<p>
			Everything start from here!
		</p>
		<p>
			<!-- register button -->
			<a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Sign up now!</a>
		</p>
	</div>
@stop