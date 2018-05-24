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

				<h4 class="mt-3 mb-4">Post Types</h4>

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

				<h4 class="mt-3 mb-4">Fields</h4>

				<div class="form-group">
					<label class="form-label">Name</label>
					<input type="text" name="fields[name]" value="{!! old('name') !!}" class="form-control">
				</div>

				<div class="form-group">
					<label class="form-label">Label</label>
					<input type="text" name="fields[label]" value="{!! old('label') !!}" class="form-control">
				</div>

				<div class="form-group">
					<label class="form-label">Type</label>
					<select name="fields[type]" class="form-control">
						<option value="text"<?php if( old('type') == 'text' ) : ?> selected<?php endif; ?>>Text</option>
						<option value="textarea"<?php if( old('type') == 'textarea' ) : ?> selected<?php endif; ?>>Textarea</option>
						<option value="select"<?php if( old('type') == 'select' ) : ?> selected<?php endif; ?>>Select</option>
					</select>
				</div>

				<div class="form-group">
					<label class="form-label">Options</label>
					<textarea name="fields[options]" class="form-control">{!! old('options') !!}</textarea>
				</div>

				<button type="submit" class="btn btn-primary">Update Group</button>

			</form>
			
		</div>
	</div>

@stop