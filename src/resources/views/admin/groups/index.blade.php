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
						<td>
							<form action="{!! route('balldeep.admin.groups.delete', $group) !!}" method="POST" data-confirm="are ou sure you want to delete this group?">
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

		<div class="alert alert-info">You have not yet added any custom fields</div>

	@endif

	<a href="{!! route('balldeep.admin.groups.create') !!}" class="btn btn-primary">Add Group</a>

@stop