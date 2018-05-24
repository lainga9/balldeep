@extends('balldeep::layout')

@section('title', 'Custom Fields')

@section('content')

	@if( $groups->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $groups as $group )
					<tr>
						<td><a href="{!! route('balldeep.admin.groups.edit', $group) !!}">{!! $group->name !!}</a></td>
						<td></td>
					</tr>
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">You have not yet added any custom fields</div>

	@endif

	<a href="{!! route('balldeep.admin.groups.create') !!}" class="btn btn-primary">Add Custom Field</a>

@stop