@if( $field->options )
	@foreach( $field->options as $option )
		<div class="checkbox">
			<input 
				type="checkbox"
				id="{!! $field->name !!}-{!! $option !!}"
				value="{!! $option !!}"
				name="{!! $field->name !!}[]"
				<?php if( in_array($option, $value ?: []) ) : ?>
					checked
				<?php endif; ?>
			>
			<label for="{!! $field->name !!}-{!! $option !!}">{!! $option !!}</label>
		</div>
	@endforeach
@endif