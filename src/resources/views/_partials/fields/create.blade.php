<div data-row-index="{!! $index !!}" data-row-html="{!! route('balldeep.admin.ajax.field.create') !!}">

	<div class="form-group<?php if( $errors->has('fields.' . $index . '.label') ) : ?> has-danger<?php endif; ?>">
		<label class="form-label">Label</label>
		<input 
			type="text"
			name="fields[{!! $index !!}][label]"
			value="{!! old('fields.' . $index . '.label') !!}"
			class="form-control"
			data-generate-input-name="{!! route('balldeep.admin.ajax.utilities.input.name.generate') !!}"
			data-input-label="{!! $index !!}"
		>
	</div>

	<div class="form-group<?php if( $errors->has('fields.' . $index . '.name') ) : ?> has-danger<?php endif; ?>">
		<label class="form-label">Name</label>
		<input 
			type="text"
			name="fields[{!! $index !!}][name]"
			value="{!! old('fields.' . $index . '.name') !!}"
			class="form-control"
			data-input-name="{!! $index !!}"
		>
	</div>

	<div class="form-group<?php if( $errors->has('fields.' . $index . '.type') ) : ?> has-danger<?php endif; ?>">
		<label class="form-label">Type</label>
		<select name="fields[{!! $index !!}][type]" class="form-control" data-show-when='{!! json_encode([sprintf('.options-%d-js|select,checkboxes', $index)]) !!}'>
			<option value="text"<?php if( old('fields.' . $index . '.type') == 'text' ) : ?> selected<?php endif; ?>>Text</option>
			<option value="textarea"<?php if( old('fields.' . $index . '.type') == 'textarea' ) : ?> selected<?php endif; ?>>Textarea</option>
			<option value="select"<?php if( old('fields.' . $index . '.type') == 'select' ) : ?> selected<?php endif; ?>>Select</option>
			<option value="checkboxes"<?php if( old('fields.' . $index . '.type') == 'checkboxes' ) : ?> selected<?php endif; ?>>Checkboxes</option>
		</select>
	</div>

	<div 
		class="form-group options-{!! $index !!}-js<?php if( $errors->has('fields.' . $index . '.options') ) : ?> has-danger<?php endif; ?>"
		<?php if( old('fields.' . $index . '.type') !== 'select' ) : ?>
			style="display: none;"
		<?php endif; ?>
	>
		<label class="form-label">Options</label>
		<textarea name="fields[{!! $index !!}][options]" class="form-control">{!! old('fields.' . $index . '.options') !!}</textarea>
	</div>

	<div class="text-right">
		<a class="pricing-table__add" href="javascript:void(0)" data-add-row><i class="fa fa-plus-circle"></i></a>
		<a class="pricing-table__remove" href="javascript:void(0)" data-remove-row><i class="fa fa-minus-circle"></i></a>
	</div>

</div>