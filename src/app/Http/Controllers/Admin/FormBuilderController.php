<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Form;

class FormBuilderController extends Controller {

	/**
	 * Instance of Form model
	 * 
	 * @var Form
	 */
	protected $form;

	/**
	 * Constructor method
	 * 
	 * @param Form $form
	 */
	public function __construct(Form $form)
	{
		$this->form = $form;
	}
	
	/**
	 * Return the HTML for a form builder element so we
	 * can inject it into the DOM when using the form builder
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function getElementHtml(Request $request)
	{
		$view = sprintf('balldeep::admin.forms.builder.%s', $type = $request->get('type'));

		if( ! view()->exists($view) )
		{
			return response()->json(['html' => sprintf('View not found for %s', $type)]);
		}

		return response()->json(['html' => view($view)->render()]);
	}
}