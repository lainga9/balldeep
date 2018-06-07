<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\FormField;

class FormFieldsController extends Controller {

	/**
	 * Instance of FormField model
	 * 
	 * @var FormField
	 */
	protected $field;

	/**
	 * Constructor method
	 * 
	 * @param FormField $field
	 */
	public function __construct(FormField $field)
	{
		$this->field = $field;
	}
	
	/**
	 * Delete a form field
	 * 
	 * @param  FormField  $field
	 * @return Response
	 */
	public function delete(FormField $field)
	{
		$form = $field->form;

		$field->delete();

		return response()->json([
			'html' => view('balldeep::admin.forms.builder.fields', compact('form'))->render()
		]);
	}
}