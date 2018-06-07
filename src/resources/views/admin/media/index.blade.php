@extends('balldeep::layout')

@section('title', 'Media Gallery')

@section('content')

	@if( $media->isNotEmpty() )

		<div class="row">

			@foreach( $media as $medium )

				<div class="col-sm-6 col-md-4 col-xl-3">

					<article class="bd-media">

						<div class="bd-media__canvas">
							<a href="{!! route('balldeep.admin.media.show', $medium) !!}">
								<img src="{!! $src = $medium->getUrl('thumbnail') !!}" alt="" class="bd-media__thumb">
							</a>
						</div>

						<form 
							action="{!! route('balldeep.admin.media.delete', $medium) !!}"
							method="POST"
							data-confirm="Are you sure you want to delete this image?"
							class="bd-media__delete"
						>
							{!! csrf_field() !!}
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-plain text-danger"><i class="fa fa-trash"></i></button>
						</form>

						<p class="bd-media__name">{!! $medium->file_name !!}</p>
						<p class="bd-media__size">{!! number_format($medium->size / 1000000, 2) !!}MB</p>
						
					</article>

				</div>

			@endforeach

		</div>

	@else

		<div class="alert alert-info">You have no media in your library</div>

	@endif

@stop