@extends('balldeep::layout')

@section('title', 'Details: ' . $media->name)

@section('content')

	<div class="row">

		<div class="col-md-8">

			<img src="{!! $media->getUrl() !!}" alt="">

		</div>

		<div class="col-md-4">

			<div class="box box--bordered elem--shadow mb-3">
				<header class="box__header">
					<h4 class="box__title">File Info</h4>
				</header>
				<p><strong>Filename</strong><br> {!! $media->file_name !!}</p>
				<p><strong>Size</strong><br> {!! number_format($media->size / 1000000, 2) !!}MB</p>
				<strong>Attached To</strong><br>
				<ul class="list list--plain">
					@foreach( $media->model->posts as $post )
						<li class="list__item">
							<a href="{!! route('balldeep.admin.posts.edit', $post) !!}" target="_blank">{!! $post->title() !!}</a>
						</li>
					@endforeach
				</ul>
			</div>

			<div class="box box--bordered elem--shadow">
				<header class="box__header">
					<h4 class="box__title">Delete</h4>
				</header>
				<p>Permanently delete this media item</p>
				<form 
					action="{!! route('balldeep.admin.media.delete', $media) !!}"
					method="POST"
					data-confirm="Are you sure you want to delete this image?"
				>
					{!! csrf_field() !!}
					<input type="hidden" name="_method" value="DELETE">
					<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
				</form>
			</div>
			
		</div>

	</div>

@stop