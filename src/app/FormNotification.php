<?php

namespace Lainga9\BallDeep\app;

class FormNotification extends Model {

	const ALL_FIELDS = '{all_fields}';

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
	protected $table = 'bd_form_notifications';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot()
	{
		parent::boot();

		/**
		 * Set default values when creating notification
		 */
		static::creating(function($notification)
		{
			$subject = 	property_exists($notification, 'subject') ?
						$notification->subject :
						$notification->getDefaultSubject();

			$notification->subject = $subject;

			$content = 	property_exists($notification, 'content') ?
						$notification->content :
						$notification->getDefaultContent();

			$notification->subject = $subject;
			$notification->content = $content;
		});
	}

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
	 * Replace field entry shortcodes with their corresponding
	 * values
	 * 
	 * @param  string $content
	 * @param  FormEntry $entry
	 * @return string
	 */
	public static function parse($content, $entry)
	{
		$items = preg_match_all("/\{(.*?)\}/", $content, $matches);

        if(isset($matches[1]) && count($matches[1])) {

            foreach($matches[1] as $match)
            {
            	$parsed = $entry->value($match);

            	$content = str_replace('{' . $match . '}', $parsed, $content);
            }
        }

        return $content;
	}

	/**
	 * The default subject to set for the notification
	 * 
	 * @return string
	 */
	public function getDefaultSubject()
	{
		return sprintf('New submission from %s', $this->form->name);
	}

	/**
	 * Return default content for notification
	 * 
	 * @return string
	 */
	public function getDefaultContent()
	{
		return '{all_fields}';
	}

	/**
	 * Return the subject of the notification
	 * 
	 * @return string
	 */
	public function subject($entry)
	{
		return self::parse($this->subject, $entry);
	}

	/**
	 * Return the parsed content of the notification. This can
	 * include shortcodes which access values from the form
	 * entry which triggered the notification
	 * 
	 * @param  FormEntry $entry
	 * @return string
	 */
	public function content($entry)
	{
		$content = trim($this->content);

		if( $content == self::ALL_FIELDS )
		{
			return view('balldeep::emails.forms._partials.all', compact('entry'))->render();
		}

		return self::parse($this->content, $entry);
	}
}