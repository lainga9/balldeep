@extends('balldeep::login')

@section('title', 'Login')

@section('content')

	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<form action="{!! route('balldeep.login.do') !!}" method="POST">

				{!! csrf_field() !!}

				<div class="form-group">
					<label class="form-label">Email</label>
					<input type="email" class="form-control" name="email">
				</div>

				<div class="form-group">
					<label class="form-label">Password</label>
					<input type="password" class="form-control" name="password">
				</div>

				<button type="submit" class="btn btn-primary">Login</button>
				
			</form>	
		</div>
	</div>

@stop