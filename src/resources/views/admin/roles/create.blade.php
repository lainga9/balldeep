@extends('balldeep::layout')

@section('content')

	<form action="{!! route('balldeep.admin.roles.store') !!}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="name" class="form-label">Name</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name') !!}">
		</div>
		<div class="form-group">
			<label for="title" class="form-label">Title</label>
			<input type="text" id="title" name="title" class="form-control" value="{!! old('title') !!}">
		</div>
		<button type="submit" class="btn btn-primary">Save Role</button>
	</form>

@stop