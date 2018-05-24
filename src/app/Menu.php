<?php

namespace Lainga9\BallDeep\app;

class Menu extends Model {

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
	protected $table = 'bd_menus';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * All items which are in the menu including posts and custom
	 * 
	 * @return HasMany
	 */
	public function items()
	{
		return $this->hasMany('Lainga9\BallDeep\app\MenuItem');
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	public static function html($name)
	{
		$menu = static::where('name', $name)->first();

		if( ! $menu ) return '';

		return view('balldeep::frontend._partials.menus', $name)->render();
	}
}