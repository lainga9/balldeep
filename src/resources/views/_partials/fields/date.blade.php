<input 
	id="test"
	type="date"
	name="{!! $field->name !!}"
	class="{!! $field->class ?: 'form-control' !!}"
	data-datepicker
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