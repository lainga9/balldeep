<?php

namespace Lainga9\BallDeep\app;

use Exception;

class PostMeta extends Model {

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
	protected $table = 'bd_post_meta';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The post to which the meta belongs
	 * 
	 * @return HasMany
	 */
	public function post()
	{
		return $this->belongsTo('Lainga9\BallDeep\app\Post', 'post_id');
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Serialize value if it's an array
	 * 
	 * @param string|array $value
	 */
	public function setValueAttribute($value)
	{
		if( is_array($value) ) $value = serialize($value);

		$this->attributes['value'] = $value;
	}

	/**
	 * Unserialise value if required
	 * 
	 * @param  string $value
	 * @return string|array
	 */
	public function getValueAttribute($value)
	{
		try
		{
			return unserialize($value);
		}

		catch( Exception $e )
		{
			return $value;
		}
	}

	/**
	 * Return the value for the meta item
	 * 
	 * @return string
	 */
	public function value()
	{
		return $this->value;
	}
}