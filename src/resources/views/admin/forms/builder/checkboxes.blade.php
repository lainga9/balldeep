@if( $field->options )
	@foreach( $field->options as $option )
		<div>
			<input type="checkbox" readonly disabled>
			<label class="form-label"><small>{!! $option !!}</small></label>
		</div>
	@endforeach
@else
	<div>
		<input type="checkbox" readonly disabled>
		<label class="form-label"><small>Option 1</small></label>
	</div>
	<div>
		<input type="checkbox" readonly disabled>
		<label class="form-label"><small>Option 2</small></label>
	</div>
	<div>
		<input type="checkbox" readonly disabled>
		<label class="form-label"><small>Option 3</small></label>
	</div>
@endif