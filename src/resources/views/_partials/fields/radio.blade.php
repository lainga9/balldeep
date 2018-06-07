@if( $field->options )
	@foreach( $field->options as $option )
		<div class="radio">
			<input 
				type="radio"
				id="{!! $field->name !!}-{!! $option !!}"
				value="{!! $option !!}"
				name="{!! $field->name !!}"
				<?php if( $value == $option ) : ?>
					selected
				<?php endif; ?>
			>
			<label for="{!! $field->name !!}-{!! $option !!}">{!! $option !!}</label>
		</div>
	@endforeach
@endif