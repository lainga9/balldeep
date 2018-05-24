@extends('balldeep::layout')

@section('title', 'Edit Taxonomy')

@section('content')

	<form action="{!! route('balldeep.admin.taxonomies.update', $taxonomy) !!}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<div class="form-group">
			<label for="name" class="form-label">Title</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name', $taxonomy->name) !!}">
		</div>
		<button type="submit" class="btn btn-primary">Update Taxonomy</button>
	</form>

@stop