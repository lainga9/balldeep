@extends('balldeep::layout')

@section('content')

	@if( $media->isNotEmpty() )

		<div class="row">

			@foreach( $media as $medium )

				<div class="col-sm-3">
					
					<h4>{!! $medium->name !!}</h4>

					<img src="{!! $medium->getUrl('thumbnail') !!}" alt="">

					<form action="{!! route('balldeep.admin.media.delete', $medium) !!}" method="POST" data-confirm="Are you sure you want to delete this file?">
						<input type="hidden" name="_method" value="DELETE">
						{!! csrf_field() !!}
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>

				</div>

			@endforeach

		</div>

	@else

		<div class="alert alert-info">You have no media in your library</div>

	@endif

@stop