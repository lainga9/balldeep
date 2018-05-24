<input 
	type="text"
	name="meta[{!! $field->name !!}]"
	class="{!! $field->class ?: 'form-control' !!}"
	@if( $field->required )
		required
	@endif
	@if( $placeholder = $field->placeholder )
		placeholder="{!! $placeholder !!}"
	@endif
	@if( $value = $field->value )
		value="{!! $value !!}"
	@endif
>