<div class="mb-5" data-id="{!! $field->id !!}">

	<div class="form-group">
		<label 
			data-toggle="collapse" data-target=".field-{!! $field->id !!}"
			class="form-label"
			style="cursor: pointer;"
		>
			<small>(ID: {!! $field->id !!})</small> {!! $field->label !!}
		</label>
		<div class="bdf">
			<div class="bdf__preview">
				{!! $field->adminPreview() !!}
			</div>
		</div>
	</div>

	<div class="collapse field-{!! $field->id !!}">

		<div class="box box--bordered elem--shadow mb-4">

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
				<label class="form-label">Description</label>
				<input 
					type="text"
					name="fields[{!! $field->id !!}][meta][description]"
					class="form-control"
					value="{!! $field->description !!}"
				>
			</div>

			@if( $field->hasOptions() )

				<div class="form-group options-{!! $field->id !!}-js">
					<label class="form-label">Options</label>
					<textarea name="fields[{!! $field->id !!}][options]" class="form-control" rows="6">{!! $field->options ? implode(PHP_EOL, $field->options) : ''!!}</textarea>
				</div>

			@endif

			<div class="form-group">
				<label class="form-label">Required</label>
				<input 
					type="checkbox"
					name="fields[{!! $field->id !!}][required]"
					value="1"
					@if( $field->required )
						checked
					@endif 
				>
			</div>
			
			<button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this field?" data-delete-field="{!! route('balldeep.admin.forms.fields.delete', $field) !!}">Delete Field</button>

		</div>
		
	</div>
	
</div>