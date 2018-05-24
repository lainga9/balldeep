@extends('balldeep::layout')

@section('content')

	@if( $roles->isNotEmpty() )

		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $roles as $role )
					<tr>
						<td>{!! $role->id !!}</td>
						<td><a href="{!! route('balldeep.admin.roles.edit', $role) !!}">{!! $role->name !!}</a></td>
						<td>{!! $role->title !!}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	@else

		<div class="alert alert-info">No roles configured yet</div>

	@endif

	<a href="{!! route('balldeep.admin.roles.create') !!}" class="btn btn-primary">Add Role</a>

@stop