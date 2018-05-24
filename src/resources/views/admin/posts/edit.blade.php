@extends('balldeep::layout')

@section('title', sprintf('Edit %s: %s', ucwords($post->type->name), $post->name))

@section('content')

	<form action="{!! route('balldeep.admin.posts.update', $post) !!}" method="POST" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">

		<div class="row">

			<div class="col-md-8">

				<div class="form-group">
					<label for="name" class="form-label">Title</label>
					<input type="text" id="name" name="name" class="form-control" value="{!! old('name', $post->name) !!}">
				</div>
				<div class="form-group">
					<label for="name" class="form-label">Content</label>
					<textarea 
						name="content"
						class="form-control"
						data-trumbo
					>{!! old('content', $post->content) !!}</textarea>
				</div>

				@if( $post->type->metaGroups->isNotEmpty() )

					@foreach( $post->type->metaGroups as $group )

						<div class="box box--bordered mb-4">
							<header class="box__header">
								<p class="box__title">{!! $group->name !!}</p>
							</header>
							@foreach( $group->fields()->inOrder()->get() as $field )
								<div class="form-group">
									<label class="form-label">{!! $field->label() !!}</label>
									{!! $field->display($post->meta($field->name)) !!}
								</div>
							@endforeach
						</div>

					@endforeach

				@endif
				
			</div>

			<div class="col-md-4">

				<div class="mb-4">
					<a target="_blank" href="{!! $post->url() !!}" class="btn btn-secondary">View on Frontend</a>
					<button type="submit" class="btn btn-primary">Update {!! ucwords($post->type->name) !!}</button>
				</div>

				@if( $post->type->hierarchical )

					<div class="box mb-4 box--bordered">
						<header class="box__header">
							<p class="box__title">{!! ucwords($post->type->name) !!} Attributes</p>
						</header>
						<div class="form-group">
							<label class="form-label">Parent</label>
							<select name="post_parent_id" class="form-control">
								<option value="0">Please Select</option>
								@foreach( $post->type->posts()->not($post->id)->alphabetical()->get() as $other )
									<option 
										<?php if( $post->post_parent_id == $other->id ) : ?>
											selected
										<?php endif; ?>
										value="{!! $other->id !!}"
									>{!! $other->name !!}</option>
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
							@if( $post->type->taxonomies->isNotEmpty() )
								@foreach( $post->type->taxonomies as $tax )
									<li class="list__item">
										<input 
											type="checkbox"
											id="tax-{!! $tax->id !!}" 
											value="{!! $tax->id !!}"
											name="taxonomies[]"
											<?php if( $post->isInTaxonomy($tax) ) : ?>
												checked
											<?php endif; ?>
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
						<a href="#" data-toggle="modal" data-target=".modal-add-taxonomy-js"><small><i class="fa fa-plus"></i> Add new</small></a>
					</footer>
				</div>

				<div class="box box--bordered">
					<header class="box__header">
						<p class="box__title">Featured Image</p>
					</header>
					<div class="bd-fimage">
						<div class="image-js">
							@php( $src = ($post->media && $post->media->getFirstMediaUrl('featured')) ? $post->media->getFirstMediaUrl('featured') : 'http://placehold.it/600x360' )
							<img 
								data-load-html="{!! route('balldeep.admin.ajax.media-gallery') !!}"
								data-html-container=".media-gallery-js"
								src="{!! $src !!}"
								data-src-orig="{!! $src !!}"
								data-src-placeholder="http://placehold.it/600x360"
								alt=""
								class="mb20 image-js bd-fimage__thumb"
								data-upload-image="image"
							>
						</div>
						<div class="new-image-js"></div>
						<input type="file" name="image" class="d-none" data-image-upload=".image-js">
						<div class="mb-3"></div>
						<button type="button" class="btn btn-info" data-load-html="{!! route('balldeep.admin.ajax.media-gallery') !!}" data-html-container=".media-gallery-js">Select</button>
						<button type="button" class="btn btn-warning" data-upload-trigger="image">Upload</button>
						<button type="button" class="btn btn-plain bd-fimage__delete text-danger" data-delete-trigger="image"><i class="fa fa-trash"></i></button>
						<button type="button" class="btn btn-secondary" data-reset-trigger="image">Reset</button>
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
					<form action="{!! route('balldeep.admin.taxonomies.store', $post->type) !!}" method="POST" data-store-taxonomy>
						{!! csrf_field() !!}
						<input type="text" name="name" class="form-control mb-2">
						<button type="submit" class="btn btn-primary">Add Taxonomy</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	@include('balldeep::_partials.modals.media')

@stop