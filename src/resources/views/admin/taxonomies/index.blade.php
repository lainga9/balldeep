@extends('balldeep::layout')

@section('title', sprintf('%s Taxonomies', ucwords($type->name)))

@section('content')

	@if( $taxonomies->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>{!! ucwords(str_plural($type->name)) !!}</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $taxonomies as $tax )
					<tr>
						<td><a href="{!! route('balldeep.admin.taxonomies.edit', $tax) !!}">{!! $tax->name !!}</a></td>
						<td><a href="{!! route('balldeep.admin.posts.index', [$type, 'taxonomy' => $tax->id]) !!}">{!! $tax->posts()->count() !!}</a></td>
						<td>
							<form action="{!! route('balldeep.admin.taxonomies.delete', $tax) !!}" method="POST" data-confirm="Are you sure you want to delete this taxonomy?">
								{!! csrf_field() !!}		
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" class="btn btn-plain text-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">You have not yet added any taxonomies for {!! str_plural(lcfirst($type->name)) !!}</div>

	@endif

	<a href="{!! route('balldeep.admin.taxonomies.create', $type) !!}" class="btn btn-primary">Add Taxonomy</a>


@stop