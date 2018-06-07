@extends('balldeep::layout')

@section('title', 'Edit: ' . $form->name)

@section('content')

	<form action="{!! route('balldeep.admin.forms.update', $form) !!}" method="POST">

		{!! csrf_field() !!}

		<input type="hidden" name="_method" value="PUT">

		<div class="row">

			<div class="col-md-8">

				<div class="box box--bordered elem--shadow mb-4">
					<header class="box__header">
						<h5 class="box__title">Form Details</h5>
					</header>
					<div class="form-group<?php if( $errors->has('name') ) : ?> has-danger<?php endif; ?>">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" value="{!! old('name', $form->name) !!}">
					</div>
				</div>

				<div class="box box--bordered elem--shadow mb-4">
					<header class="box__header">
						<h5 class="box__title">Fields</h5>
					</header>

					<div data-form-fields>

						@include('balldeep::admin.forms.builder.fields', compact('form'))
						
					</div>

				</div>
				
			</div>

			<div class="col-md-4">

				<div data-add-fields="{!! route('balldeep.admin.forms.fields.add', [$form]) !!}">

					<div class="row mb-3">
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="text">Text</button>	
						</div>
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="textarea">Textarea</button>	
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="select">Select</button>	
						</div>
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="checkboxes">Checkboxes</button>	
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="radio">Radio Buttons</button>	
						</div>
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="email">Email</button>	
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="tel">Tel</button>	
						</div>
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="number">Number</button>	
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-6">
							<button class="btn btn-block mb-1 btn-info" type="button" data-add-field="date">Date</button>	
						</div>
					</div>

				</div>
				
			</div>

		</div>
		
		<button type="submit" class="btn btn-primary">Update Form</button>

	</form>

@stop