@foreach( $entry->content as $label => $value )

	<div>
		<strong>{!! str_replace('_', ' ', ucwords($label)) !!}:</strong>
		@if( is_array($value) )
			<ul>
				@foreach( $value as $v )
					<li>{!! $v !!}</li>
				@endforeach
			</ul>
		@else
			{!! $value !!}
		@endif
	</div>

@endforeach