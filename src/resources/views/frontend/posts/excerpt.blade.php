<article class="bd-post bd-post--{!! $type->slug !!}" bd-post--excerpt>
	@if( $post->media && ($item = $post->media->getFirstMedia('featured')) )
		<a href="{!! $post->url() !!}">
			{!! $item->img('thumbnail', ['class' => 'bd-post__thumbnail']) !!}
		</a>
	@endif
	<header class="bd-post__header">
		<h3 class="bd-post__title">
			<a class="bd-post__link" href="{!! $post->url() !!}">{!! $post->title() !!}</a>
		</h3>
		<div class="bd-post__meta">
			<span class="bd-post__published">{!! $post->publishedAt() !!}</span>
		</div>
	</header>
	<div class="bd-post__excerpt">{!! $post->excerpt() !!}</div>
	<a href="{!! $post->url() !!}" class="bd-post__button button">Read More</a>
</article>