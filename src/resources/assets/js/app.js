window.$ = window.jQuery = require('jquery');

require('./jquery-ui.min');
require('trumbowyg');
window.Tether = require('tether');
require('bootstrap');
require('summernote');

jQuery(document).ready(function($) {

	$('[data-content-editor]').each(function() {
		var $this = $(this);

		var ShortcodesButton = function(context) {

			var ui = $.summernote.ui;

			var $contents = $this.data('shortcodes');

			return ui.buttonGroup([
				ui.button({
					className: 'dropdown-toggle',
					contents: '<span class="fa fa-envelope"></span> <span class="caret"></span>',
					tooltip: "Insert Form",
					data: {
						toggle: 'dropdown'
					},
					click: function() {
						context.invoke('editor.saveRange');
					}
				}),
				ui.dropdown({
					className: 'dropdown-variables',
					contents: $contents,
					callback: function ($dropdown) {
						$dropdown.find('div').each(function () {
							$(this).click(function() {
								context.invoke('editor.restoreRange');
								context.invoke('editor.focus');
								context.invoke("editor.insertText", $(this).data('code'));
							});
						});
					}
				})]).render();
		}

		$this.summernote({
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['mybutton', ['shortcodes']]
			],
			buttons: {
    			shortcodes: ShortcodesButton
  			}
		});
	});

	/*
	 * Insert text to an input at the cursor position
	 */
	$(document).on('click', '[data-insert-text]', function(e) {
		e.preventDefault();
		var $this = $(this);
		var $input = $($this.data('insert-input'));
		if( $input.length > 0 ) {
			var $pos = $input[0].selectionStart;
			var $existing = $input.val();
			var $toAdd = $this.data('insert-text');
			$input.val($existing.substring(0, $pos) + $toAdd + $existing.substring($pos));
		} else {
			console.error('Input ' + $this.data('insert-input') + ' not found');
		}
	});

	/*
	 * Form Builder
	 */
	var $formBuilder = (function() {

		var $container = $('[data-form-fields]'),

		initEvents = function() {
			$(document).on('click', '[data-add-field]', function(e) {
				e.preventDefault();
				var $this = $(this);
				$.ajax({
					type: "POST",
					url: $this.closest('[data-add-fields]').data('add-fields'),
					data: {
						_token: $('meta[name="csrf-token"]').prop('content'),
						type: $this.data('add-field'),
					},
					success: function(response) {
						$container.append(response.html);
					},
					error: function(response) {
						console.error(response);
					}
				});
			});

			$(document).on('click', '[data-delete-field]', function(e) {
				e.preventDefault();
				var $this = $(this);
				var $confirm = confirm($(this).data('confirm'));
				if( ! $confirm ) return false;
				$.ajax({
					type: "POST",
					url: $this.data('delete-field'),
					data: {
						_token: $('meta[name="csrf-token"]').prop('content'),
						_method: 'DELETE'
					},
					success: function(response) {
						$container.html(response.html);
					}
				});
			});
		},

		init = function() {
			initEvents();
		};

		return {init: init};

	})();

	$formBuilder.init();

	/*
	 * Conditional logic
	 */
	$(document).on('change', '[data-show-when]', function() {
		var $this = $(this);
		var $val = $this.val();
		var $rules = $this.data('show-when');
		$.each($rules, function($index, $value) {
			var $pieces = $value.split('|');
			var $elem = $($pieces[0]);
			if( $elem.length > 0 ) {
				var $matches = $pieces[1];
				if( $matches.indexOf(',') > -1 ) {
					$matches = $matches.split(',');
					if( $matches.indexOf($val) > -1 ) {
						$elem.show();
					} else {
						$elem.hide();
					}
				} else {
					if( $pieces[1] == $val ) {
						$elem.show();
					} else {
						$elem.hide();
					}
				}
			}
		});
	});

	/*
	 * When entering text in a label field, 
	 * automatically populate the name field
	 */
	$(document).on('blur', '[data-input-label]', function() {
		var $this = $(this);
		var $val = $this.val();
		console.log($this.data('input-label'));
		$.ajax({
			type: "GET",
			url: $this.data('generate-input-name'),
			data: {
				string: $val
			},
			success: function(response) {
				var $name = $this.data('input-label');
				var $input = $('[data-input-name="' + $name + '"]');
				if( response.hasOwnProperty('string') && $input.length > 0 ) {
					$input.val(response.string);
				}
			}
		});
	});

	/*
	 * Allow client to add or remove additional 
	 * rows when, for example, adding in custom
	 * fields
	 */
	var $addRows = (function() {

		var $trigger = $('[data-add-row]'),

		setRowsInput = function() {
			$('input[name="rows"]').val($('[data-row-index]').length);
		},

		addRow = function() {
			var $prev = $('[data-row-index]').last();
			var $index = $prev.data('row-index') + 1;
			$.ajax({
				type: "GET",
				url: $prev.data('row-html'),
				data: {
					index: $index
				},
				success: function(response) {
					$prev.closest('[data-row-container]').append(response.html);
					setRowsInput();
				}
			})
		},

		initEvents = function() {
			$(document).on('click', '[data-add-row]', function(e) {
				e.preventDefault();
				addRow();
			});
			$(document).on('click', '[data-remove-row]', function(e) {
				e.preventDefault();
				var $count = $('[data-row-index]').length;
				if( $count > 1 ) {
					$(this).closest('[data-row-index]').remove();
				}
			});
		},

		init = function() {
			setRowsInput();
			initEvents();
		};

		return {init: init};

	})();

	$addRows.init();

	/*
	 * Bootstrap collapses
	 */
	$(document).on('click', '[data-toggle="collapse"]', function(e) {
		e.preventDefault();
		$(this).collapse();
	});

	$.trumbowyg.svgPath = '/vendor/balldeep/icons.svg';

	/*
	 * Submit forms without using submit button
	 */
	$(document).on('change', '[data-submit-on-change]', function() {
		var $form = $(this).closest('form');
		if( $form.length > 0 ) {
			$form.submit();
		}
	});

	/*
	 * WYSIWYG editors
	 */
	$('[data-trumbo]').each(function() {
		var $this = $(this);
		var $config = {};
		if( typeof $this.data('trumbo-config') === 'undefined' ) {
			var $buttons = [
				['undo', 'redo'], 
				['formatting'],
				['strong', 'em', 'del'],
				['superscript', 'subscript'],
				['link'],
				['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
				['unorderedList', 'orderedList'],
				['horizontalRule'],
				['removeformat'],
				['fullscreen']
			];
		} else {
			$config = $this.data('trumbo-config');
		}
		$this.trumbowyg($config);
	});

	/*
	 * Select media from popup gallery
	 */
	$(document).on('click', '[data-select-media]', function(e) {
		var $this = $(this);
		var $name = $this.data('select-media');
		var $imageTarget = $('[data-upload-image="' + $name + '"]');
		if( $imageTarget.length > 0 ) {
			$imageTarget.prop('src', $this.data('media-src'));
			var $form = $imageTarget.closest('form');
			if( $form.length > 0 ) {
				var $input = $form.find('input[name="media_id"]');
				if( $input.length > 0 ) {
					$input.val($this.data('media-id'));
				} else {
					$form.prepend(
						$('<input>')
							.prop('type', 'hidden')
							.prop('name', 'media_id')
							.val($this.data('media-id'))
					)
				}
			}
		}
		if( $this.closest('.modal').length > 0 ) {
			$this.closest('.modal').first().modal('hide');
		}
	});

	/*
	 * Load HTML via ajax and inject it into specifed
	 * container in DOM
	 */
	$(document).on('click', '[data-load-html]', function(e) {
		e.preventDefault();
		var $this = $(this);
		var $container = $($this.data('html-container'));
		if( $container.length > 0 ) {
			$.ajax({
				type: "GET",
				url: $this.data('load-html'),
				success: function(response) {
					if( $container.closest('.modal').length > 0 ) {
						$container.closest('.modal').first().modal('show');
					}
					$container.html(response.html);
				},
				error: function(response) {
					console.error(response);
				}
			});
		}
	});

	/**
	 * Handle image uploads
	 */
	var $imageUploads = (function() {

		var $uploads = $('[data-image-upload]'),
			$buttons = $('[data-upload-trigger]'),
			$deletes = $('[data-delete-trigger]'),
			$resets = $('[data-reset-trigger]'),

		init = function() {
			$(document).on('click', '[data-upload-trigger]', function(e) {
				e.preventDefault();
				var $data = $(this).data('upload-trigger');
				var $target = $('input[name="' + $data + '"]');
				$target.trigger('click');
			});
			$deletes.on('click', function(e) {
				e.preventDefault();
				var $data = $(this).data('delete-trigger');
				$(this).closest('form').append('<input type="hidden" name="' + $data + '_remove" value="">');
				var $image = $('[data-upload-image="' + $data + '"]');
				$image.prop('src', $image.data('src-placeholder'));
			});
			$resets.on('click', function(e) {
				e.preventDefault();
				var $data = $(this).data('reset-trigger');
				var $image = $('[data-upload-image="' + $data + '"]');
				$image.prop('src', $image.data('src-orig'));
				$(this).closest('form').find('input[name="' + $data + '_remove"]').remove();
			});
			$uploads.each(function() {
				var $this = $(this);
				$this.on('change', function () {
					if (this.files && this.files[0]) {
						var reader = new FileReader();
						reader.onload = function(e) {
							var $target = $($this.data('image-upload'));
							$this.closest('form').find('input[name="' + $this.prop('name') + '_remove"]').remove();
							if( $target.length > 0 ) {
								$target.attr('src', e.target.result);
							}
						}
						reader.readAsDataURL(this.files[0]);
					}
				});
			});
		};

		return {init: init};

	})();

	$imageUploads.init();

	/*
	 * Prompt for confirmation when submitting forms 
	 */
	$(document).on('submit', '[data-confirm]', function() {
		var $confirm = confirm($(this).data('confirm'));
		if( ! $confirm ) return false;
	});

	/*
	 * Add new taxonomies
	 */
	$(document).on('submit', '[data-store-taxonomy]', function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.find('.alert').remove();
		var $button = $this.find('button[type="submit"]');
		var $html = $button.html();
		var $spinner = $('<i>').prop('class', 'fa fa-spin fa-spinner');
		var $modal = $this.closest('.modal');
		$button.html($spinner).prop('disabled', true);
		$.ajax({
			type: $this.prop('method'),
			url: $this.prop('action'),
			data: $this.serialize(),
			success: function(response) {
				if( response.hasOwnProperty('taxonomy') ) {
					var $li = $('<li>');
					var $input = $('<input>')
									.prop('type', 'checkbox')
									.prop('id', 'tax-' + response.taxonomy.id)
									.prop('name', 'taxonomies[]')
									.prop('checked', true)
									.val(response.taxonomy.id);
					var $label = $('<label>')
									.prop('for', 'tax-' + response.taxonomy.id)
									.text(response.taxonomy.name);
					$('[data-list-taxonomies]').append($li.append($input).append($label));
					if( $modal.length > 0 ) {
						$modal.modal('hide');
					}
				}
			},
			error: function(response) {
				if( response.status == 422 ) {
					var $errors = $('<div>').prop('class', 'alert alert-danger')
					$this.prepend($errors);
					$.each( response.responseJSON.errors, function(i,v) {
						$errors.append('<p>' + v + '</p>');
					} );
					$button.html($html).prop('disabled', false);
				}
			}
		}).done(function() {
			$button.html($html).prop('disabled', false);
		});
	});

	/*
	 * Sortable menu items
	 */
	$('[data-sortable]').each(function() {
		var $this = $(this);
		$this.sortable({
			interactsWith: '.children',
			placeholder: 'placeholder',
			sort: function(e, ui) {
				var $pos = ui.position.left;
				if( ui.helper.hasClass('sortable-nested') ) {
					$pos = ui.position.left + 40;
				}
				if( $pos > 40 ) {
					ui.placeholder.addClass('sortable-nested');
					ui.helper.addClass('sortable-nested');
				} else {
					ui.placeholder.removeClass('sortable-nested');
					ui.helper.removeClass('sortable-nested');
				}
			},
			stop: function(e, ui) {
				var $children = $this.children();

				// Don't allow first item to be indented
				$children.first().removeClass('sortable-nested');

				// Container for our item data which will be
				// passed via ajax request
				var $items = [];

				$children.each(function() {

					// Assume it has no parent
					var $parent = 0;

					// Get index of element in list
					var $index = $(this).index();

					// If it's not the top item and it has
					// been nested then we need to find out
					// which elem is it's parent. Since we
					// only allow nesting one deep we need
					// to make sure to find the closest
					// parent which is not nested
					if( $index > 0 && $(this).hasClass('sortable-nested') ) {

						var $parentElem;

						// Get all of the elements above
						// the given item
						var $elemsAbove = $children.slice(0, $index);

						// Loop through elems and if they have
						// not been nested updated $parentElem
						// element. Because we are looping
						// through them in order the closest
						// one to given item will be the result
						$elemsAbove.each(function() {
							if( ! $(this).hasClass('sortable-nested') ) {
								$parentElem = $(this);
							}
						});
						if( typeof $parentElem !== 'undefined' ) {
							$parent = $parentElem.data('id');
						}
					}
					$items.push({
						id: $(this).data('id'),
						order: $(this).index() + 1,
						parent: $parent
					});
				});
				var $data = {
					items: JSON.stringify($items),
					_token: $('meta[name="csrf-token"]').prop('content')
				};
				$.ajax({
					type: "POST",
					url: $this.data('sortable'),
					data: $data,
					success: function(response) {
						console.log(response);
					},
					error: function(response) {
						console.error(response);
					}
				});
			},
			update: function(e, ui) {

			}
		});
	});

});