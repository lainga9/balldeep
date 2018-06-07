@extends('balldeep::layout')

@section('title', 'Edit Notification')

@section('content')

	<form action="{!! route('balldeep.admin.forms.notifications.update', $notification) !!}" method="POST">
		
		{!! csrf_field() !!}

		<input type="hidden" name="_method" value="PUT">

		<div class="row">

			<div class="col-md-8">

				<div class="form-group mb-5">
					<span class="dropdown float-right">
						<a href="#" data-toggle="dropdown">Fields <i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu">
							@if( $notification->form->fields->isNotEmpty() )
								@foreach( $notification->form->fields as $field )
									<li><a href="#" data-insert-text="{!! sprintf('{%s}', $field->name) !!}" data-insert-input='input[name="name"]'>{!! $field->label !!}</a></li>
								@endforeach
							@else
								<li>No fields in form</li>
							@endif
						</ul>
					</span>
					<label class="form-label">Name</label>
					<input type="text" name="name" class="form-control" value="{!! old('name', $notification->name) !!}">
				</div>

				<div class="form-group mb-5">
					<span class="dropdown float-right">
						<a href="#" data-toggle="dropdown">Fields <i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu">
							@if( $notification->form->fields->isNotEmpty() )
								@foreach( $notification->form->fields as $field )
									<li><a href="#" data-insert-text="{!! sprintf('{%s}', $field->name) !!}" data-insert-input='input[name="subject"]'>{!! $field->label !!}</a></li>
								@endforeach
							@else
								<li>No fields in form</li>
							@endif
						</ul>
					</span>
					<label class="form-label">Subject</label>
					<input type="text" name="subject" class="form-control" value="{!! old('subject', $notification->subject) !!}">
				</div>

				<div class="form-group mb-5">
					<span class="dropdown float-right">
						<a href="#" data-toggle="dropdown">Fields <i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu">
							@if( $notification->form->fields->isNotEmpty() )
								@foreach( $notification->form->fields as $field )
									<li><a href="#" data-insert-text="{!! sprintf('{%s}', $field->name) !!}" data-insert-input='input[name="email"]'>{!! $field->label !!}</a></li>
								@endforeach
							@else
								<li>No fields in form</li>
							@endif
						</ul>
					</span>
					<label class="form-label">Recipient Email</label>
					<input type="text" name="email" class="form-control" value="{!! old('email', $notification->email) !!}">
				</div>

				<div class="form-group mb-5">
					<span class="dropdown float-right">
						<a href="#" data-toggle="dropdown">Fields <i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="#" data-insert-text="{all_fields}" data-insert-input='textarea[name="content"]'>All Fields</a></li>
							@foreach( $notification->form->fields as $field )
								<li><a href="#" data-insert-text="{!! sprintf('{%s}', $field->name) !!}" data-insert-input='textarea[name="content"]'>{!! $field->label !!}</a></li>
							@endforeach
						</ul>
					</span>
					<label class="form-label">Content</label>
					<textarea name="content" class="form-control">{!! old('content', $notification->content) !!}</textarea>
				</div>

				<div class="form-group mb-5">
					<label class="form-label">Active?</label>
					<select name="active" class="form-control">
						<option value="0">No</option>
						<option value="1" <?php if( old('active', $notification->active) ) : ?> selected<?php endif; ?>>Yes</option>
					</select>
				</div>
				
			</div>

			{{-- <div class="col-md-4">

				<h4 class="mt-0 mb-4">Insert Field</h4>

				@if( $notification->form->fields->isNotEmpty() )
					@foreach( $notification->form->fields as $field )
						<div class="mb-1">
							<a href="#" data-insert-input='input[name="email"]'>{!! $field->label !!}</a>
						</div>
					@endforeach
				@else
					<li>No fields in form</li>
				@endif
				
			</div> --}}

		</div>
		
		<button type="submit" class="btn btn-primary">Save Notification</button>
		
	</form>

@stop