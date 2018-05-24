@extends('balldeep::layout')

@section('title', ucwords(str_plural($type->name)))

@section('content')

	<div style="margin-top: -25px">
		<form action="{!! route('balldeep.admin.posts.index', $type) !!}">
			<div class="row">
				<div class="col-sm-3 offset-sm-9">
					<div class="form-group mb-0">
						<select name="taxonomy" class="form-control" data-submit-on-change>
							<option value="">Taxonomy (Any)</option>
							@foreach( $type->taxonomies as $tax )
								<option 
									<?php if( $tax->id == request()->input('taxonomy') ) : ?>
										selected
									<?php endif; ?>
									value="{!! $tax->id !!}"
								>{!! $tax->name !!}</option>
							@endforeach
						</select>
					</div>	
				</div>
			</div>
		</form>
	</div>

	<hr class="mt-3 mb-3">

	@if( $posts->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Title</th>
					<th>Taxonomies</th>
					<th>Published</th>
					<th>Updated</th>
					<th>View</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $posts as $post )
					<tr>
						<td><a href="{!! route('balldeep.admin.posts.edit', $post) !!}">{!! $post->name !!}</a></td>
						<td>{!! implode(', ', $post->taxonomies->pluck('name')->toArray()) !!}</td>
						<td>{!! $post->created_at->format('d/m/y g:ia') !!}</td>
						<td>{!! $post->updated_at->format('d/m/y g:ia') !!}</td>
						<td><a target="_blank" href="{!! $post->url() !!}"><i class="fa fa-search"></i></a></td>
						<td>
							<form action="{!! route('balldeep.admin.posts.delete', $post) !!}" method="POST" data-confirm="Are you sure you want to delete this post?">
								{!! csrf_field() !!}		
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" class="btn btn-plain text-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
					@foreach( $post->children as $child )
						<tr>
							<td><a href="{!! route('balldeep.admin.posts.edit', $child) !!}"> - {!! $child->name !!}</a></td>
							<td>{!! implode(', ', $child->taxonomies->pluck('name')->toArray()) !!}</td>
							<td>{!! $child->created_at->format('d/m/y g:ia') !!}</td>
							<td>{!! $child->updated_at->format('d/m/y g:ia') !!}</td>
							<td><a target="_blank" href="{!! $child->url() !!}"><i class="fa fa-search"></i></a></td>
							<td>
								<form action="{!! route('balldeep.admin.posts.delete', $child) !!}" method="POST" data-confirm="Are you sure you want to delete this post?">
									{!! csrf_field() !!}		
									<input type="hidden" name="_method" value="DELETE">
									<button type="submit" class="btn btn-plain text-danger"><i class="fa fa-trash"></i></button>
								</form>
							</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">No {!! str_plural(strtolower($type->name)) !!} found</div>

	@endif

	<a href="{!! route('balldeep.admin.posts.create', $type) !!}" class="btn btn-primary">Add {!! $type->name !!}</a>

	<a href="{!! route('balldeep.admin.taxonomies.index', $type) !!}" class="btn btn-primary">Taxonomies</a>	

@stop