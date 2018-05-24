@if( $media->isNotEmpty() )

	<div class="row">

		@foreach( $media as $medium )

			<div class="col-sm-6 col-md-4 col-xl-3">

				<article class="bd-media">

					<div class="bd-media__canvas">
						<img src="{!! $src = $medium->getUrl('thumbnail') !!}" alt="" class="bd-media__thumb" data-select-media="image" data-media-src="{!! $src !!}" data-media-id="{!! $medium->id !!}">
					</div>

					<p class="bd-media__name">{!! $medium->file_name !!}</p>

					{{-- <button type="submit" class="mt-2 btn btn-success" data-select-media="image" data-media-src="{!! $src !!}" data-media-id="{!! $medium->id !!}">Select</button> --}}
					
				</article>

			</div>

		@endforeach

	</div>

@else

	<div class="alert alert-info">You have no media in your library</div>

@endif