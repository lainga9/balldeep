@extends('balldeep::layout')

@section('content')

	@if( $posts->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Title</th>
					<th>Taxonomies</th>
					<th>View</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $posts as $post )
					<tr>
						<td><a href="{!! route('balldeep.admin.posts.edit', $post) !!}">{!! $post->name !!}</a></td>
						<td>{!! implode(', ', $post->taxonomies->pluck('name')->toArray()) !!}</td>
						<td><a target="_blank" href="{!! $post->url() !!}">View</a></td>
						<td>
							<form action="{!! route('balldeep.admin.posts.delete', $post) !!}" method="POST" data-confirm="Are you sure you want to delete this post?">
								{!! csrf_field() !!}		
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">You have not yet added any {!! str_plural(ucwords(strtolower($type->name))) !!}</div>

	@endif

	<a href="{!! route('balldeep.admin.posts.create', $type->slug) !!}" class="btn btn-primary">Add {!! $type->name !!}</a>

	<a href="{!! route('balldeep.admin.taxonomies.index', $type->slug) !!}" class="btn btn-primary">Taxonomies</a>	

@stop