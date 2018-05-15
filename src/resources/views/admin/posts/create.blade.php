@extends('balldeep::layout')

@section('content')

	<form action="{!! route('balldeep.admin.posts.store', $type) !!}" method="POST" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="name" class="form-label">Title</label>
			<input type="text" id="name" name="name" class="form-control" value="{!! old('name') !!}">
		</div>
		<div class="form-group">
			<label for="name" class="form-label">Content</label>
			<textarea name="content" class="form-control">{!! old('content') !!}</textarea>
		</div>
		<div class="form-group">
			<label class="form-label">Categories</label>
			<ul data-list-taxonomies>
				@if( $type->taxonomies->isNotEmpty() )
					@foreach( $type->taxonomies as $tax )
						<li>
							<input 
								type="checkbox"
								id="tax-{!! $tax->id !!}" 
								value="{!! $tax->id !!}"
								name="taxonomies[]"
							>
							<label for="tax-{!! $tax->id !!}">{!! $tax->name !!}</label>
						</li>
					@endforeach
				@endif
			</ul>
			<a href="#" data-toggle="modal" data-target=".modal-add-taxonomy-js"><i class="fa fa-plus"></i> Add new</a>
		</div>
		<div class="form-group">
			<label class="form__label">Featured Image</label>
			<div class="image-js">
				@php($src = 'http://placehold.it/600x360')
				<img 
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
			<button type="button" class="btn btn-warning" data-upload-trigger="image">Upload New Image</button>
			<button type="button" class="btn btn-danger" data-delete-trigger="image">Delete</button>
			<button type="button" class="btn btn-secondary" data-reset-trigger="image">Reset</button>
		</div>
		<button type="submit" class="btn btn-primary">Save Post</button>
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

@stop