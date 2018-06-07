<?php

namespace Lainga9\BallDeep\app;

class Setting extends Model
{
    /**
     * Table columns which cannot be mass assigned
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table name in the database
     * 
     * @var string
     */
    protected $table = 'bd_settings';

    /*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Retrieve a setting's value by its key
	 * 
	 * @param  string $key
	 * @return mixed
	 */
	public static function getValue($key)
	{
		$setting = self::where('key', $key)->first();

		return $setting ? $setting->{$setting->type} : null;
	}
}
