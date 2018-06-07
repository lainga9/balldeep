@extends('balldeep::layout')

@section('title', 'Add Group')

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

			<form action="{!! route('balldeep.admin.groups.store') !!}" method="POST">

				{!! csrf_field() !!}

				<div class="form-group mb-5">
					<label class="form-label">Name</label>
					<input type="text" name="name" class="form-control" value="{!! old('name') !!}">
				</div>

				{{-- <div class="box box--bordered elem--shadow mt-3 mb-4">
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
							>
							<label for="type-{!! $type->id !!}">{!! $type->name !!}</label>
						</div>
					
					@endforeach
				</div>

				<div class="box box--bordered elem--shadow mt-3 mb-4">
					<header class="box__header">
						<h4 class="box__title">Fields</h4>
					</header>

					<div data-row-container>

						@for ($i = 0; $i < Session::get('rows', 1); $i++ )

							@include('balldeep::_partials.fields.create', ['index' => $i])

						@endfor
						
					</div>

				</div> --}}

				<button type="submit" class="btn btn-primary">Save Group</button>

			</form>
			
		</div>
	</div>

@stop