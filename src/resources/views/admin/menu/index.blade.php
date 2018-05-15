@extends('balldeep::layout')

@section('content')

	@if( $menus->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $menus as $menu )
					<tr>
						<td><a href="{!! route('balldeep.admin.menu.manage', $menu) !!}">{!! $menu->name !!}</a></td>
						<td>
							<form action="{!! route('balldeep.admin.menu.delete', $menu) !!}" method="POST">
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

		<div class="alert alert-info">You have not yet added any menus</div>

	@endif

	<a href="{!! route('balldeep.admin.menu.create') !!}" class="btn btn-primary">Add Menu</a>

@stop