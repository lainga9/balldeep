@extends('balldeep::layout')

@section('title', 'Notifications: ' . $form->name)

@section('content')

	@if( $form->notifications->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $form->notifications as $notification )
					<tr>
						<td><a href="{!! route('balldeep.admin.forms.notifications.edit', $notification) !!}">{!! $notification->name !!}</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>


	@else

		<div class="alert alert-info">No notifications found</div>

	@endif

	<a class="btn btn-primary" href="{!! route('balldeep.admin.forms.notifications.create', $form) !!}">Create Notification</a>

@stop