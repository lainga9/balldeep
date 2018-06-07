@extends('balldeep::layout')

@section('title', 'Forms')

@section('content')

	@if( $forms->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Entries</th>
					<th>Notifications</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $forms as $form )
					<tr>
						<td>{!! $form->id !!}</td>
						<td><a href="{!! route('balldeep.admin.forms.edit', $form) !!}">{!! $form->name !!}</a></td>
						<td><a href="{!! route('balldeep.admin.forms.entries', $form) !!}"><i class="fa fa-eye"></i></a></td>
						<td><a href="{!! route('balldeep.admin.forms.notifications.index', $form) !!}"><i class="fa fa-envelope"></i></a></td>
						<th>{!! $form->created_at->format('d M y g:ia') !!}</th>
					</tr>
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">No forms found</div>

	@endif

	<a href="{!! route('balldeep.admin.forms.create') !!}" class="btn btn-primary">Add Form</a>

@stop