<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\FormEntry;

class FormEntriesController extends Controller {

	/**
	 * Instance of FormEntry model
	 * 
	 * @var FormEntry
	 */
	protected $entry;

	/**
	 * Constructor method
	 * 
	 * @param FormEntry $entry
	 */
	public function __construct(FormEntry $entry)
	{
		$this->entry = $entry;
	}
	
	/**
	 * Show a form entry
	 * 
	 * @param  Entry  $entry
	 * @return Response
	 */
	public function show(FormEntry $entry)
	{
		return view('balldeep::admin.forms.entries.show', compact('entry'));
	}
}