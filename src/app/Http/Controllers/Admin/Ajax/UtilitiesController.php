<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin\Ajax;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilitiesController extends Controller {

	/**
	 * Convert a string into one which is suitable
	 * for use as an input name (in a form)
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function generateInputName(Request $request)
	{
		return response()->json([
			'string' => str_replace('-', '_', str_slug($request->get('string')))
		]);
	}

	/**
	 * Return the HTML required when adding additional
	 * custom fields
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function getCreateFieldHtml(Request $request)
	{
		return response()->json([
			'html' 	=> view('balldeep::_partials.fields.create', ['index' => $request->get('index', 1)])->render()
		]);
	}
}