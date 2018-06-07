@if( $form->fields->isNotEmpty() )

	<div data-sortable="{!! route('balldeep.admin.forms.fields.reorder', $form) !!}" class="form-fields">

		@foreach( $form->fields()->inOrder()->get() as $field )

			@include('balldeep::admin.forms.builder.field', compact('field'))

		@endforeach

	</div>

@else

	<div class="alert alert-info">You have not yet added any fields</div>

@endif