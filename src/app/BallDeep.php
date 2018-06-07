<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Menu;
use Lainga9\BallDeep\app\Form;
use Lainga9\BallDeep\app\Post;
use Exception;
use StdClass;

class BallDeep {

	/**
	 * Return the tags required for FB open graph nonsense
	 * 
	 * @param  string $title
	 * @param  string $description
	 * @param  string $link
	 * @param  string $image
	 * @return string
	 */
	public static function getFacebookMetaTags($title, $link, $image, $description = null, $type = 'product')
	{
		return sprintf('
			<meta property="og:title" content="%s">
			<meta property="og:description" content="%s">
			<meta property="og:image" content="%s">
			<meta property="og:url" content="%s">
			<meta property="og:email" content="%s">
			<meta property="og:type" content="%s">
			<meta property="og:site_name" content="%s">
		', $title, $description, $image, $link, self::setting('site_email'), $type, config('app.name'));
	}

	/**
	 * Return the tags required for Twitter social nonsense
	 * 
	 * @param  string $title
	 * @param  string $description
	 * @param  string $image
	 * @return string
	 */
	public static function getTwitterMetaTags($title, $image, $description = null)
	{
		return sprintf('
			<meta name="twitter:title" content="%s">
			<meta name="twitter:description" content="%s">
			<meta name="twitter:image" content="%s">
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@%s" />
			<meta name="twitter:creator" content="@%s" />
		', $title, $description, $image, $handle = self::setting('twitter_handle'), $handle);
	}

	public static function seo()
	{

	}

	/**
	 * Return stylesheet element to add to head of site
	 * 
	 * @return string
	 */
	public static function styles()
	{
		return sprintf('<link rel="stylesheet" href="%s">', asset('vendor/balldeep/frontend.css'));
	}

	/**
	 * Return script element to add to footer of site
	 * 
	 * @return string
	 */
	public static function scripts()
	{
		return sprintf('<script src="%s"></script>', asset('vendor/balldeep/frontend.js'));
	}

	/**
	 * Return a collection of post types
	 * 
	 * @param  array  $types
	 * @param  integer $limit
	 * @return Collection
	 */
	public static function posts($types, $limit = -1)
	{
		if( ! $types ) return collect();

		if( ! is_array($types) )
		{
			$types = [$types];
		}

		return Post::whereHas('type', function($query) use ($types)
		{
			$query->whereIn('slug', $types);
		})
		->limit($limit)
		->get();
	}

	/**
	 * Displays a form on the frontend
	 * 
	 * @param  integer $id
	 * @return string
	 */
	public static function form($id, $title = true)
	{
		$form = Form::find($id);

		if( ! $form ) return sprintf('Form %d not found', $id);

		return $form->display($title);
	}

	/**
	 * Display a menu somewhere on the frontend.
	 *
	 * The available parameters are:
	 *
	 * container_class: CSS class to add to the <nav> element
	 * menu_class: CSS class to be added to the <ul> element
	 * item_class: CSS class to be added to the <li> element
	 * link_class: CSS class to be added to the <a> element
	 * 
	 * @param  string $name name of the menu
	 * @param  array $params optional parameters
	 * @return string
	 */
	public static function menu($name, $params = [])
	{
		$menu = Menu::where('name', $name)->first();

		if( ! $menu ) return sprintf('Menu %s not found', $name);

		$path = view()->exists($path = 'vendor.balldeep._partials.menu') ? 
				$path : 
				'balldeep::frontend._partials.menu';

		return view($path, compact('menu', 'params'))->render();
	}

	/**
	 * Trims a string to the specified maximum length
	 * 
	 * @param  string  $string
	 * @param  integer $maxLength
	 * @return string
	 */
	public static function trimString($string, $maxLength = 200)
	{
		if( ! $string ) return $string;
		
		$ellipsis = '...';

		if( strlen($string) > ($maxLength - strlen($ellipsis)) )
		{
			$string = sprintf('%s%s', substr($string, 0, $maxLength - strlen($ellipsis)), $ellipsis);
		}

		return $string;
	}

	/**
	 * Return the main site email address as defined in settings 
	 * panel. If none is set then return first admin's email
	 * 
	 * @return string
	 */
	public function siteEmailAddress()
	{
		$setting = Setting::getValue('site_email');

		return $setting ?: User::admin()->first()->email;
	}

	/**
	 * Retrieve a site setting
	 * 
	 * @param  string $key 
	 * @return mixed
	 */
	public static function setting($key)
	{
		return Setting::getValue($key);
	}

}