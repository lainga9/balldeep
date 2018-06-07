<select 
	name="{!! $field->name !!}"
	class="{!! $field->class ?: 'form-control' !!}"
	@if( $field->required )
		required
	@endif
>
	<option value="">{!! $field->placeholder ?: 'Please Select' !!}</option>
	@if( $field->options )
		@foreach( $field->options as $option )
			<option 
				value="{!! $option !!}"
				<?php if( $value == $option ) : ?>
					selected
				<?php endif; ?>
			>{!! $option !!}</option>
		@endforeach
	@endif
</select>