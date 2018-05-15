@extends('balldeep::layout')

@section('content')

	@if( $taxonomies->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $taxonomies as $tax )
					<tr>
						<td>{!! $tax->name !!}</td>
						<td>
							<form action="{!! route('balldeep.admin.taxonomies.delete', $tax) !!}" method="POST" data-confirm="Are you sure you want to delete this taxonomy?">
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

		<div class="alert alert-info">You have not yet added any taxonomies for {!! str_plural(lcfirst($type->name)) !!}</div>

	@endif

	<a href="{!! route('balldeep.admin.taxonomies.create', $type->slug) !!}" class="btn btn-primary">Add Taxonomy</a>


@stop