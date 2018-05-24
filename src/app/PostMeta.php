<?php

namespace Lainga9\BallDeep\app;

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
	 * Return the value for the meta item
	 * 
	 * @return string
	 */
	public function value()
	{
		return $this->value;
	}
}