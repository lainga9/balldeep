@extends('balldeep::layout')

@section('content')

	<form action="{!! route('balldeep.admin.menu.store') !!}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="name" class="form-label">Name</label>
			<input type="text" id="name" name="name" class="form-control">
		</div>
		<button type="submit" class="btn btn-primary">Save Menu</button>
	</form>

@stop