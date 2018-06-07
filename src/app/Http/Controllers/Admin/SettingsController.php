<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Lainga9\BallDeep\app\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller {

	/**
	 * Instance of Setting model
	 * 
	 * @var Setting
	 */
	protected $setting;

	/**
	 * Constructor method
	 */
	public function __construct(Setting $setting)
	{
		$this->setting = $setting;
	}

	/**
	 * Show settings page
	 * 
	 * @return Response
	 */
	public function index()
	{
		return view('balldeep::admin.settings.index');
	}

	/**
	 * Update settings
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function update(Request $request)
	{
		$settings = $request->get('settings');

		if( ! ( is_array($settings) && count($settings) ) )
		{
			return redirect()->back()->with('info', 'Nothing to update');
		}

		foreach( $settings as $key => $params )
		{
			$setting = $this->setting->where(compact('key'))->first();

			if( $setting )
			{
				$setting->update($params);
			}
			else
			{
				$setting = $this->setting->create(compact('key') + $params);
			}
		}

		return redirect()->back()->with('success', 'Settings updated!');
	}
}