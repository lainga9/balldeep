<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Fields\FieldFactory;
use Lainga9\BallDeep\app\Fields\FieldAttributes;
use Exception;

class Form extends Model {

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
	protected $table = 'bd_forms';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot()
	{
		parent::boot();

		static::created(function($form)
		{
			$form->notifications()->create([
				'name' 		=> 'Admin',
				'subject'	=> sprintf('New Submission From %s', $form->name),
				'content' 	=> '{all_fields}',
				'email'		=> BallDeep::siteEmailAddress(),
				'active'	=> 1
			]);
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The fields attached to the form
	 * 
	 * @return HasMany
	 */
	public function fields()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\FormField',
			'form_id'
		);
	}

	/**
	 * The entries submitted for the form
	 * 
	 * @return HasMany
	 */
	public function entries()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\FormEntry',
			'form_id'
		);
	}

	/**
	 * The notifications for the form
	 * 
	 * @return HasMany
	 */
	public function notifications()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\FormNotification',
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
	 * Return an individual field
	 * 
	 * @param  integer $id
	 * @return Response
	 */
	public function field($id)
	{
		return $this->fields()->find($id);
	}

	/**
	 * Used to display the form on the frontend
	 * 
	 * @return string
	 */
	public function display($title)
	{
		/**
		 * Default view for form
		 */
		$path = 'vendor.balldeep._partials.form';

		if( view()->exists($custom = sprintf('forms.%d', $this->id)) )
		{
			$path = $custom;
		}

		$fields = [];

		foreach( $this->fields()->inOrder()->get() as $field )
		{
			try
			{
				$field = FieldFactory::getField(new FieldAttributes($field));

				$fields[] = $field;
			}

			catch( Exception $e )
			{
				$fields[] = $e;
			}
		}

		return view($path, ['form' => $this] + compact('fields', 'title'))->render();
	}
}