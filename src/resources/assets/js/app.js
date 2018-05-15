window.$ = window.jQuery = require('jquery');

require('./jquery-ui.min');

jQuery(document).ready(function($) {

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
			update: function(e, ui) {
				var $items = [];
				$this.find('li').each(function() {
					$items.push({
						id: $(this).data('id'),
						order: $(this).index() + 1
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
			}
		});
	});

});