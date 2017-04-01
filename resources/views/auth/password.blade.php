@extends('layouts.default')
@section('title', 'reset password')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-offset-2 col-md-8 ">
			<div class="panel panel-default">
				<div class="panel-heading">
					Reset password
				</div>
				<div class="panel-body">
					@include('shared.errors')
					<form method="POST" action="{{ route('password.reset') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-md-4 control-label" for="email">email:</label>
							<div class="col-md-offset-2 col-md-6 ">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}"/>
							</div>	
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">reset</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	
</div>

@stop