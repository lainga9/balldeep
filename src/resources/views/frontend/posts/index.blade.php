@extends('layouts.' . config('balldeep.layout'))

@section('content')

	@foreach( $posts as $post )

		<a href="{!! $post->url() !!}">{!! $post->title() !!} - <small>{!! $post->publishedAt() !!}</small></a>

	@endforeach

@stop