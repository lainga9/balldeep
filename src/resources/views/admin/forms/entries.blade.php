@extends('balldeep::layout')

@section('title', 'Form Entries: ' . $form->name)

@section('content')

	@if( $entries->isNotEmpty() )

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $entries as $entry )
					<tr>
						<td><a href="{!! route('balldeep.admin.forms.entries.show', $entry) !!}">{!! $entry->id !!}</a></td>
						<th>{!! $entry->created_at->format('d M y g:ia') !!}</th>
					</tr>
				@endforeach
			</tbody>
		</table>

	@else

		<div class="alert alert-info">No entries found</div>

	@endif

	{!! $entries->render() !!}

@stop