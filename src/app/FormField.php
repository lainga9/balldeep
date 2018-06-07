<?php

namespace Lainga9\BallDeep\app;

class FormField extends Model {

	/*
	|--------------------------------------------------------------------------
	| Variables
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Table columns which cannot be mass assigned
	 * 
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The name of the table in the DB
	 * 
	 * @var string
	 */
	protected $table = 'bd_form_fields';

	/**
	 * The field types which should have options 
	 * attached e.g. select, checkboxes etc
	 * 
	 * @var array
	 */
	protected static $typesWithOptions = [
		'select',
		'checkboxes',
		'radio'
	];

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot()
	{
		parent::boot();

		/**
		 * Set the order of the field as 1 more
		 * than the previous one
		 */
		static::creating(function($field)
		{
			$field->order = self::where([
				'form_id' => $field->form_id]
			)->max('order') + 1;
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The form to which the field belongs
	 * 
	 * @return HasMany
	 */
	public function form()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\Form',
			'form_id'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Options are added as new lines in a textarea. 
	 * Convert these new lines into an array and then
	 * serialise them.
	 * 
	 * @param string $options
	 */
	public function setOptionsAttribute($options)
	{
		$options = preg_split("/\R/", $options);

		$options = array_filter(array_map(function($elem) {
			return trim($elem);
		}, $options));

		$this->attributes['options'] = serialize($options);
	}

	/**
	 * Unserialise the stored options when returning them.
	 * 
	 * @param  string $options
	 * @return string
	 */
	public function getOptionsAttribute($options)
	{
		if( ! $options ) return null;

		return unserialize($options);
	}

	/**
	 * Serialise any additional meta regarding the field e.g
	 * description, css class etc
	 * 
	 * @param array $meta
	 */
	public function setMetaAttribute($meta)
	{
		$this->attributes['meta'] = serialize($meta);
	}

	/**
	 * Unserialise any additional meta regarding the field 
	 * e.g description, css class etc
	 * 
	 * @param array $meta
	 */
	public function getMetaAttribute($meta)
	{
		if( ! $meta ) return null;

		return unserialize($meta);
	}

	public function getDescriptionAttribute()
	{
		return $this->getMeta('description');
	}

	public function getMeta($key)
	{
		return 	$this->meta && array_key_exists($key, $this->meta) ?
				$this->meta[$key] :
				null;
	}

	/**
	 * Return the name of the input based on the ID
	 * 
	 * @return string
	 */
	public function getNameAttribute()
	{
		return str_replace('-', '_', str_slug($this->label));
	}

	/**
	 * Used to display the field in the edit view in admin
	 * 
	 * @return string
	 */
	public function adminPreview()
	{
		$view = sprintf('balldeep::admin.forms.builder.%s', $this->type);

		if( ! view()->exists($view) )
		{
			return sprintf('View: %s not found', $view);
		}

		return view($view, ['field' => $this])->render();
	}

	/*
	|--------------------------------------------------------------------------
	| Checks
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Check if the form field should have options attached to
	 * it e.g. dropdown, checkboxes etc
	 * 
	 * @return boolean
	 */
	public function hasOptions()
	{
		return in_array($this->type, self::$typesWithOptions);
	}
}