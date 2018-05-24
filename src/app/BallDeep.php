<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Menu;

class BallDeep {

	/**
	 * Display a menu somewhere on the frontend
	 * 
	 * @param  string $name name of the menu
	 * @return string
	 */
	public static function menu($name)
	{
		$menu = Menu::where('name', $name)->first();

		if( ! $menu ) return '';

		$path = view()->exists($path = 'vendor.balldeep._partials.menu') ? 
				$path : 
				'balldeep::frontend._partials.menu';

		return view($path, compact('menu'))->render();
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

}