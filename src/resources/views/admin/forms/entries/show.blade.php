@extends('balldeep::layout')

@section('title', 'Entry #' . $entry->id)

@section('content')

	@foreach( $entry->content as $label => $value )

		<div class="form-group">
			<label class="form-label"><strong>{!! str_replace('_', ' ', ucwords($label)) !!}:</strong></label>
			@if( is_array($value) )
				<ul class="list">
					@foreach( $value as $v )
						<li class="list__item">{!! $v !!}</li>
					@endforeach
				</ul>
			@else
				{!! $value !!}
			@endif
		</div>

	@endforeach

@stop