@extends('layouts.' . config('balldeep.layout'))

@section('content')

	<article class="bd-post bd-post--{!! $post->type->slug !!}">

		<h1 class="bd-post__title">{!! $post->title() !!}</h1>

		@if( $post->taxonomies->isNotEmpty() )
			<ul class="bd-post__taxonomies">
				@foreach( $post->taxonomies as $tax )
					<li class="bd-post__taxonomies-item">
						<a class="bd-post__taxonomies-link" href="{!! $tax->link() !!}">{!! $tax->name !!}</a>
					</li>
				@endforeach
			</ul>
		@endif

		<div class="bd-post__meta">
			<p class="bd-post__published">{!! $post->publishedAt() !!}</p>
		</div>

		@if( $post->media && ($item = $post->media->getFirstMedia('featured')) )

			{!! $item->img('', ['class' => 'bd-post__image img-fluid']) !!}

		@endif

		<div class="bd-post__content">
			{!! $post->content() !!}
		</div>

	</article>

@stop