@extends('layouts.' . config('balldeep.layout'))

@section('content')

	<h1>{!! $post->title() !!}</h1>

	@if( $post->taxonomies->isNotEmpty() )
		<ul>
			@foreach( $post->taxonomies as $tax )
				<li><a href="{!! $tax->link() !!}">{!! $tax->name !!}</a></li>
			@endforeach
		</ul>
	@endif

	@if( $post->media && ($item = $post->media->getFirstMedia('featured')) )

		{!! $item->toHtml() !!}

	@endif

	<p>{!! $post->publishedAt() !!}</p>

	<hr>

	{!! $post->content() !!}

	<p><strong>Stadium: </strong>{!! $post->meta('stadium') !!}</p>

@stop