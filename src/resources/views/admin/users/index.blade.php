@extends('balldeep::layout')

@section('title', 'Users')

@section('content')

	@if( $users->isNotEmpty() )

		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $users as $user )
					<tr>
						<td>{!! $user->id !!}</td>
						<td>{!! $user->name() !!}</td>
						<td>{!! $user->email !!}</td>
						<td>{!! implode(', ', $user->roles->pluck('title')->toArray()) !!}</td>
						<td>
							{{-- <a href="{!! route('balldeep.admin.users.abilities', $user) !!}">Abilities</a> --}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	@else

		<div class="alert alert-info">No users in the system</div>

	@endif

	<a href="{!! route('balldeep.admin.users.create') !!}" class="btn btn-primary">Add User</a>

@stop