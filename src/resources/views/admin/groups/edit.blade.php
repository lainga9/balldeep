@extends('balldeep::layout')

@section('title', 'Edit Group: ' . $group->name)

@section('after_styles')

	<style>

		table.table {
			margin-bottom: 0;
		}

		th,
		td {
			width: 33%;
		}
		
	</style>

@stop

@section('content')

	<div class="row">
		<div class="col-md-8">

			<form action="{!! route('balldeep.admin.groups.update', $group) !!}" method="POST">

				{!! csrf_field() !!}

				<input type="hidden" name="_method" value="PUT">

				<div class="form-group mb-5">
					<label class="form-label">Name</label>
					<input type="text" name="name" class="form-control" value="{!! $group->name !!}">
				</div>

				<div class="box box--bordered elem--shadow mt-3 mb-4">
					<header class="box__header">
						<h4 class="box__title">Post Types</h4>
					</header>
					@foreach( $types as $type )
					
						<div>
							<input 
								id="type-{!! $type->id !!}"
								type="checkbox"
								name="types[]"
								value="{!! $type->id !!}"
								<?php if( $group->postTypes->contains($type->id) ) : ?>
									checked
								<?php endif; ?>
							>
							<label for="type-{!! $type->id !!}">{!! $type->name !!}</label>
						</div>
					
					@endforeach
				</div>

				<div class="box box--bordered elem--shadow mt-3 mb-4">
					<header class="box__header">
						<h4 class="box__title">Fields</h4>
					</header>

					<div data-form-fields>
						@include('balldeep::admin.groups.fields', compact('group'))
					</div>

				</div>

				<button type="submit" class="btn btn-primary">Update Group</button>

			</form>
			
		</div>

		<div class="col-md-4">

			<div class="box box--bordered elem--shadow mb-4">
				<header class="box__header">
					<h4 class="box__title">Add Fields</h4>
				</header>

				<div data-add-fields="{!! route('balldeep.admin.groups.fields.add', $group) !!}">
					
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

				</div>

				{{-- <form action="{!! route('balldeep.admin.groups.fields.add', $group) !!}" method="POST">

					{!! csrf_field() !!}

					<div data-row-container>

						@for ($i = 0; $i < session('rows', 1); $i++ )

							@include('balldeep::_partials.fields.create', ['index' => $i])

						@endfor

					</div>

					<button type="submit" class="btn btn-primary">Add Fields</button>

				</form> --}}

			</div>
			
		</div>
	</div>

@stop