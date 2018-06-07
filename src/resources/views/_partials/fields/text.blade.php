<input 
	type="text"
	name="{!! $field->name !!}"
	class="{!! $field->class ?: 'form-control' !!}"
	@if( $field->required )
		required
	@endif
	@if( $placeholder = $field->placeholder )
		placeholder="{!! $placeholder !!}"
	@endif
	@if( $value )
		value="{!! $value !!}"
	@endif
>