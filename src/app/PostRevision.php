<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Traits\Sluggable;

class PostRevision extends Model {
	
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
	protected $table = 'bd_post_revisions';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The post to which the revision belongs
	 * 
	 * @return Post
	 */
	public function post()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\Post',
			'post_id'
		);
	}

	/**
	 * The user who made the update
	 * 
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\User',
			'user_id'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return content of the revision
	 * 
	 * @return string
	 */
	public function content()
	{
		return $this->content;
	}
}