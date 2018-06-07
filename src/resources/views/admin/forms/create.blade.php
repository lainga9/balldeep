@extends('balldeep::layout')

@section('title', 'Create a Form')

@section('content')

	<form action="{!! route('balldeep.admin.forms.store') !!}" method="POST">

		{!! csrf_field() !!}

		<div class="row">

			<div class="col-md-8">

				<div class="box box--bordered elem--shadow mb-4">
					<header class="box__header">
						<h5 class="box__title">Form Details</h5>
					</header>
					<div class="form-group<?php if( $errors->has('name') ) : ?> has-danger<?php endif; ?>">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" value="{!! old('name') !!}">
					</div>
				</div>
				
			</div>

		</div>
		
		<button type="submit" class="btn btn-primary">Save Form</button>

	</form>

@stop