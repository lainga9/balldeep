<?php

namespace Lainga9\BallDeep\app;

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

	public function setOptionsAttribute($options)
	{
		$options = preg_split("/\R/", $options);

		$this->attributes['options'] = serialize($options);
	}

	public function getOptionsAttribute($options)
	{
		if( ! $options ) return null;

		return unserialize($options);
	}

	public function model()
	{
		try
		{
			return Fields\FieldFactory::getField($this);
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
}