<?php

namespace Lainga9\BallDeep\app\Http\Controllers;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Form;
use Lainga9\BallDeep\app\Http\Requests\SubmitFormRequest;

class FormsController extends Controller {

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
	
	public function submit(Form $form, SubmitFormRequest $request)
	{
		$entry = $form->entries()->create([
			'content' => $request->except('_token'),
			'user_id' => $request->user() ? $request->user()->id : null
		]);

		$entry->notify();

		return redirect()->back()->with(sprintf('form_%d_success', $form->id), 'Thanks, we have received your submission!');
	}
}