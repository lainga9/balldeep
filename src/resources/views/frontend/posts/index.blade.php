@extends('layouts.' . config('balldeep.layout'))

@section('content')

	<div class="bd-grid bd-grid--{!! $type->slug !!}">

		@foreach( $posts as $post )

			<div class="bd-grid__item">

				{!! $post->template('excerpt') !!}
				
			</div>

		@endforeach

	</div>

	<div class="bd-pagination">
		{!! $posts->links() !!}
	</div>

@stop