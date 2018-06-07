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
							<label class="form-label">Label</label>
							<input 
								type="text"
								name="fields[{!! $field->id !!}][label]"
								class="form-control"
								value="{!! $field->label !!}"
							>
						</div>

						<div class="form-group">
							<label class="form-label">Name</label>
							<input 
								type="text"
								name="fields[{!! $field->id !!}][name]"
								class="form-control"
								value="{!! $field->name !!}"
							>
						</div>

						<div class="form-group options-{!! $field->id !!}-js" 
							<?php if( ! $field->hasOptions() ) : ?>
								style="display: none;"
							<?php endif; ?>
						>
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