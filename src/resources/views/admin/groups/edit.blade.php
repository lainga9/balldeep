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

				<h4 class="mt-3 mb-4">Post Types</h4>

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

				<h4 class="mt-5 mb-4">Fields</h4>

				@if( $group->fields->isNotEmpty() )

					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Label</th>
								<th>Name</th>
								<th>Type</th>
							</tr>
						</thead>
					</table>

					<ul class="list list--plain list--fields" data-sortable="{!! route('balldeep.admin.groups.fields.reorder', $group) !!}">

						@foreach( $group->fields()->inOrder()->get() as $index => $field )

							<li class="list__item" data-id="{!! $field->id !!}">

								<div data-toggle="collapse" data-target=".field-{!! $index !!}">

									<table class="table table-bordered">
										<tbody>
											<tr>
												<td>{!! $field->label !!}</td>
												<td>{!! $field->name !!}</td>
												<td>{!! $field->type !!}</td>
											</tr>
										</tbody>
									</table>

								</div>

								<div class="collapse field-{!! $index !!}">

									<div class="box">

										<div class="form-group">
											<label class="form-label">Name</label>
											<input type="text" name="fields[{!! $field->id !!}][name]" class="form-control" value="{!! $field->name !!}">
										</div>

										<div class="form-group">
											<label class="form-label">Label</label>
											<input type="text" name="fields[{!! $field->id !!}][label]" class="form-control" value="{!! $field->label !!}">
										</div>

										<div class="form-group">
											<label class="form-label">Type</label>
											<select name="fields[{!! $field->id !!}][type]" class="form-control">
												<option value="text"<?php if( old('fields.' . $field->id . '.type', $field->type) == 'text' ) : ?> selected<?php endif; ?>>Text</option>
												<option value="textarea"<?php if( old('fields.' . $field->id . '.type', $field->type) == 'textarea' ) : ?> selected<?php endif; ?>>Textarea</option>
												<option value="select"<?php if( old('fields.' . $field->id . '.type', $field->type) == 'select' ) : ?> selected<?php endif; ?>>Select</option>
											</select>
										</div>

										<div class="form-group">
											<label class="form-label">Options</label>
											<textarea name="fields[{!! $field->id !!}][options]" class="form-control">{!! old('fields.' . $index . '.options', $field->options ? implode(PHP_EOL, $field->options) : null) !!}</textarea>
										</div>
										
									</div>
									
								</div>

							</li>

						@endforeach
						
					</ul>

				@else

					<div class="alert alert-info">There are no fields in this group yet</div>

				@endif

				<button type="submit" class="btn btn-primary">Update Group</button>

			</form>
			
		</div>

		<div class="col-md-4">

			<h4 class="mt-0 mb-4">Add Field</h4>

			<form action="{!! route('balldeep.admin.groups.fields.add', $group) !!}" method="POST">

				{!! csrf_field() !!}

				<div class="form-group">
					<label class="form-label">Name</label>
					<input type="text" name="name" value="{!! old('name') !!}" class="form-control">
				</div>

				<div class="form-group">
					<label class="form-label">Label</label>
					<input type="text" name="label" value="{!! old('label') !!}" class="form-control">
				</div>

				<div class="form-group">
					<label class="form-label">Type</label>
					<select name="type" class="form-control">
						<option value="text"<?php if( old('type') == 'text' ) : ?> selected<?php endif; ?>>Text</option>
						<option value="textarea"<?php if( old('type') == 'textarea' ) : ?> selected<?php endif; ?>>Textarea</option>
						<option value="select"<?php if( old('type') == 'select' ) : ?> selected<?php endif; ?>>Select</option>
					</select>
				</div>

				<div class="form-group">
					<label class="form-label">Options</label>
					<textarea name="options" class="form-control">{!! old('options') !!}</textarea>
				</div>

				<button type="submit" class="btn btn-primary">Add Field</button>

			</form>
			
		</div>
	</div>

@stop