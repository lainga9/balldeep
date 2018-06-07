<?php

namespace Lainga9\BallDeep\app;

use Notification;
use Lainga9\BallDeep\app\Notifications\FormEntryNotification;

class FormEntry extends Model {

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
	protected $table = 'bd_form_entries';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

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
	 * Store all field input values as serialised data
	 * 
	 * @param string $content
	 */
	public function setContentAttribute($content)
	{
		$this->attributes['content'] = serialize($content);
	}

	/**
	 * Unserialise the stored input values when returning them.
	 * 
	 * @param  string $content
	 * @return string
	 */
	public function getContentAttribute($content)
	{
		if( ! $content ) return null;

		return unserialize($content);
	}

	/**
	 * Return a form entry value from the serialised content
	 * 
	 * @param  string $key
	 * @return mixed
	 */
	public function value($key)
	{
		$content = $this->content;

		if( ! $content ) return '';

		return 	array_key_exists($key, $content) ?
				$content[$key] :
				'';
	}

	/**
	 * Send any notifications which have been set up for the form
	 * 
	 * @param  FormEntry $entry
	 * @return void
	 */
	public function notify()
	{
		$notifications = $this->form->notifications;

		if( $notifications->isEmpty() ) return;

		foreach( $notifications as $notification )
		{
			$email = $notification->email;

			// Means we are accessing an entry field
			if( strpos($email, '{') !== false )
			{
				$field = str_replace(['{', '}'], '', $email);

				$email = $this->value($field);
			}

			if( ! $email ) continue;

			Notification::route('mail', $email)
						->notify(new FormEntryNotification($this, $notification));
		}
	}
}