@extends('balldeep::layout')

@section('content')

	<form action="{!! route('balldeep.admin.users.store') !!}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="name" class="form-label">Name</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name') !!}">
		</div>
		<div class="form-group">
			<label for="email" class="form-label">Email</label>
			<input type="email" id="email" name="email" class="form-control" value="{!! old('email') !!}">
		</div>
		<div class="form-group">
			<label for="role" class="form-label">Role</label>
			<select name="role" id="role" class="form-control">
				<option value="">Please Select</option>
				@foreach( $roles as $role )
					<option value="{!! $role->name !!}">{!! $role->title !!}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="password" class="form-label">Password</label>
			<input type="password" id="password" name="password" class="form-control">
		</div>
		<div class="form-group">
			<label for="confirm_password" class="form-label">Confirm Password</label>
			<input type="password" id="confirm_password" name="password_confirmation" class="form-control">
		</div>
		<button type="submit" class="btn btn-primary">Save User</button>
	</form>

@stop