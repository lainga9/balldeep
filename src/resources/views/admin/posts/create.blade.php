@extends('balldeep::layout')

@section('title', sprintf('Add new %s', ucwords($type->name)))

@section('content')

	<form action="{!! route('balldeep.admin.posts.store', $type) !!}" method="POST" enctype="multipart/form-data">
		{!! csrf_field() !!}

		<div class="row">

			<div class="col-md-8">

				<div class="form-group">
					<label for="name" class="form-label">Title</label>
					<input type="text" id="name" name="name" class="form-control" value="{!! old('name') !!}">
				</div>
				<div class="form-group">
					<label for="name" class="form-label">Content</label>
					<textarea 
						data-content-editor
						name="content"
						class="form-control"
						data-shortcodes='{!! BallDeep::getFormShortcodes() !!}'
					>{!! old('content') !!}</textarea>
				</div>

				@if( $type->metaGroups->isNotEmpty() )

					@foreach( $type->metaGroups as $group )

						<div class="box box--bordered mb-4">
							<header class="box__header">
								<p class="box__title">{!! $group->name !!}</p>
							</header>
							@foreach( $group->fields()->inOrder()->get() as $field )
								<div class="form-group">
									<label class="form-label">{!! $field->label() !!}</label>
									{!! $field->display() !!}
								</div>
							@endforeach
						</div>

					@endforeach

				@endif

			</div>

			<div class="col-md-4">

				<div class="mb-4 text-right">
					<button type="submit" class="btn btn-primary">Save {!! ucwords($type->name) !!}</button>
				</div>

				@if( $type->hierarchical )

					<div class="box mb-4 box--bordered">
						<header class="box__header">
							<p class="box__title">{!! ucwords($type->name) !!} Attributes</p>
						</header>
						<div class="form-group">
							<label class="form-label">Parent</label>
							<select name="post_parent_id" class="form-control">
								<option value="0">Please Select</option>
								@foreach( $type->posts()->alphabetical()->get() as $post )
									<option value="{!! $post->id !!}">{!! $post->name !!}</option>
								@endforeach
							</select>
						</div>
					</div>

				@endif

				<div class="box mb-4 box--bordered">
					<header class="box__header">
						<p class="box__title">Categories</p>
					</header>
					<div class="form-group">
						<ul class="list list--plain mb-0" data-list-taxonomies>
							@if( $type->taxonomies->isNotEmpty() )
								@foreach( $type->taxonomies as $tax )
									<li class="list__item">
										<input 
											type="checkbox"
											id="tax-{!! $tax->id !!}" 
											value="{!! $tax->id !!}"
											name="taxonomies[]"
										>
										<label for="tax-{!! $tax->id !!}">{!! $tax->name !!}</label>
									</li>
								@endforeach
							@else
								<li class="list__item">No categories</li>
							@endif
						</ul>
					</div>
					<footer class="box__footer">
						<a href="#" data-toggle="modal" data-target=".modal-add-taxonomy-js"><i class="fa fa-plus"></i> Add new</a>
					</footer>
				</div>

				<div class="box mb-4 box--bordered">
					<header class="box__header">
						<p class="box__title">Featured Image</p>
					</header>
					<div class="form-group">
						<div class="bd-fimage">
							<div class="image-js">
								@php($src = 'http://placehold.it/600x360')
								<img 
									data-load-html="{!! route('balldeep.admin.ajax.media-gallery') !!}"
									data-html-container=".media-gallery-js"
									src="{!! $src !!}"
									data-src-orig="{!! $src !!}"
									data-src-placeholder="http://placehold.it/600x360"
									alt=""
									class="mb20 image-js"
									data-upload-image="image"
								>
							</div>
							<div class="new-image-js"></div>
							<input type="file" name="image" class="d-none" data-image-upload=".image-js">
							<div class="mb-3"></div>
							<button type="button" class="btn btn-info" data-load-html="{!! route('balldeep.admin.ajax.media-gallery') !!}" data-html-container=".media-gallery-js">Select</button>
							<button type="button" class="btn btn-warning" data-upload-trigger="image">Upload</button>
							<button type="button" class="btn btn-secondary" data-reset-trigger="image">Reset</button>
						</div>
					</div>
				</div>
				
			</div>

		</div>

	</form>


	<div class="modal fade in modal-add-taxonomy-js">
		<div class="modal-dialog">
			<div class="modal-content">
				<header class="modal-header">
					<h4 class="modal-title">Add New Taxonomy</h4>
					<a href="#" class="close" data-dismiss="modal">&times;</a>
				</header>
				<div class="modal-body">
					<form action="{!! route('balldeep.admin.taxonomies.store', $type) !!}" method="POST" data-store-taxonomy>
						{!! csrf_field() !!}
						<input type="text" name="name" class="form-control mb-2">
						<button type="submit" class="btn btn-primary btn-sm">Add Taxonomy</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	@include('balldeep::_partials.modals.media')

@stop