<div class="bd-form">

	@if( $success = session(sprintf('form_%d_success', $form->id)) )

		<div class="alert alert-success">
			{!! $success !!}
		</div>

	@endif

	@if( isset($title) && $title )

		<header class="bd-form__header">
			<h2 class="bd-form__title">{!! $form->name !!}</h2>
		</header>

	@endif

	<form action="{!! route('balldeep.forms.submit', $form) !!}" class="bd-form__form" method="POST">

		{!! csrf_field() !!}

		<input type="hidden" name="url_submitted_on" value="{!! request()->url() !!}">

		@foreach( $fields as $field )

			@if( $field instanceof Exception )

				<div class="form-group">
					{!! $field->getMessage() !!}
				</div>

			@else

				<div class="form-group<?php if( $errors->has($field->name()) ) : ?> has-danger<?php endif; ?>">
					<label for="" class="form-label">{!! $field->label() !!}</label>
					{!! $field->display() !!}
					@if( $desc = $field->description() )
						<p class="help-block">{!! $desc !!}</p>
					@endif
					@if( $errors->has($field->name()) )
						<p class="help-block">{!! $errors->first($field->name()) !!}</p>
					@endif
				</div>

			@endif

		@endforeach
		
		<button type="submit" class="btn btn-primary">Submit</button>

	</form>

</div>