@extends('balldeep::layout')

@section('title', sprintf('Add %s Taxonomy', ucwords($type->name)))

@section('content')

	<form action="{!! route('balldeep.admin.taxonomies.store', $type) !!}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="name" class="form-label">Title</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name') !!}">
		</div>
		<button type="submit" class="btn btn-primary">Save Taxonomy</button>
	</form>

@stop