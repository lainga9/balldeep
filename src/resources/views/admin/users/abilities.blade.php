@extends('balldeep::layout')

@section('content')

	<h4>{!! $user->name !!}</h4>

	@if( $user->getAbilities()->isNotEmpty() )
	
		@foreach( $user->getAbilities() as $ability )

			<div>
				<input 
					type="checkbox"
					id="ability-{!! $ability->id !!}" 
					value="{!! $ability->id !!}"
					<?php if( $user->can($ability->name) ) : ?>
						checked
					<?php endif; ?>
					name="abilities[]"
				>
				<label for="ability-{!! $ability->id !!}">{!! $ability->title !!}</label>
			</div>

		@endforeach

	@else

		<div class="alert alert-info">This user has no abilities</div>

	@endif

@stop