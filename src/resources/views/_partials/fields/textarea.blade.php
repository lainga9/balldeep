<textarea 
	name="meta[{!! $field->name !!}]"
	class="{!! $field->class ?: 'form-control' !!}"
	@if( $field->required )
		required
	@endif
	@if( $placeholder = $field->placeholder )
		placeholder="{!! $placeholder !!}"
	@endif
><?php if( $value = $field->value ) : ?>{!! $value !!}<?php endif; ?></textarea>