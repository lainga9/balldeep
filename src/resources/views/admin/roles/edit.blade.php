@extends('balldeep::layout')

@section('content')

	<form action="{!! route('balldeep.admin.roles.update', $role) !!}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<div class="form-group">
			<label for="name" class="form-label">Name</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name', $role->name) !!}">
		</div>
		<div class="form-group">
			<label for="title" class="form-label">Title</label>
			<input type="text" id="title" name="title" class="form-control" value="{!! old('title', $role->title) !!}">
		</div>

		<h4>Abilities</h4>
		
		@foreach( $role->abilities as $ability )

			<div>
				<input 
					type="checkbox"
					id="ability-{!! $ability->id !!}" 
					value="{!! $ability->id !!}"
					<?php if( $role->can($ability->name) ) : ?>
						checked
					<?php endif; ?>
					name="abilities[]"
				>
				<label for="ability-{!! $ability->id !!}">{!! $ability->title !!}</label>
			</div>

		@endforeach

		<button type="submit" class="btn btn-primary">Save Role</button>
	</form>

@stop