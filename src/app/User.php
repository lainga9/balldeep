<?php

namespace Lainga9\BallDeep\app;

use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

	use Notifiable, HasRolesAndAbilities;

	/*
	|--------------------------------------------------------------------------
	| Variables
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The auth guard as defined in config/auth.php
	 * (in main install)
	 * 
	 * @var string
	 */
	protected $guard = 'balldeep';

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
	protected $table = 'bd_users';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The posts created by the user
	 * 
	 * @return HasMany
	 */
	public function posts()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\Post',
			'user_id'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return only user's assigned the admin role
	 * 
	 * @param  Builder $query
	 * @return Builder
	 */
	public function scopeAdmin($query)
	{
		return $query->whereHas('roles', function($sub)
		{
			$sub->where('name', 'admin');
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Hash the password when touching database
	 * 
	 * @param string $password
	 */
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = bcrypt($password);
	}

	/**
	 * Return user's first name
	 * 
	 * @return string
	 */
	public function firstName()
	{
		return $this->first_name;
	}

	/**
	 * Return user's last name
	 * 
	 * @return string
	 */
	public function lastName()
	{
		return $this->last_name;
	}

	/**
	 * Return user's full name
	 * 
	 * @return string
	 */
	public function name()
	{
		return implode(' ', array_filter([
			$this->firstName(),
			$this->lastName()
		]));
	}
}