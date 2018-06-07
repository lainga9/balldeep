<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Fields\FieldAttributes;
use Exception;

class MetaField extends Model {

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
	protected $table = 'bd_meta_fields';

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

		static::creating(function($item)
		{
			$item->order = self::where([
				'meta_group_id' => $item->meta_group_id]
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
	 * The group to which the field is attached
	 * 
	 * @return MetaGroup
	 */
	public function group()
	{
		return $this->belongsTo('Lainga9\BallDeep\app\MetaField', 'meta_group_id');
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

		$options = array_map(function($elem) {
			return trim($elem);
		}, $options);

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

	public function model()
	{
		try
		{
			return Fields\FieldFactory::getField(new FieldAttributes($this));
		}

		catch( Exception $e )
		{
			throw $e;
		}
	}

	public function label()
	{
		try
		{
			return $this->model()->label();
		}

		catch( Exception $e )
		{
			return $e->getMessage();
		}
	}

	public function display($value = null)
	{
		try
		{
			return $this->model()->display($value);
		}

		catch( Exception $e )
		{
			return $e->getMessage();
		}
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