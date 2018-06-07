<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Form;
use Lainga9\BallDeep\app\Repositories\FormBuilderRepository;
use Lainga9\BallDeep\app\Http\Requests\StoreFormRequest;
use Lainga9\BallDeep\app\Http\Requests\StoreFormFieldRequest;

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
	
	public function index()
	{
		$forms = $this->form->alphabetical()->get();

		return view('balldeep::admin.forms.index', compact('forms'));
	}

	public function create()
	{
		return view('balldeep::admin.forms.create');	
	}

	public function store(StoreFormRequest $request)
	{
		$form = $this->form->create($request->all());

		return redirect()->route('balldeep.admin.forms.edit', $form)->with('success', 'Form successfully created!');
	}

	public function entries(Form $form)
	{
		$entries = $form->entries()->latest()->paginate(10);

		return view('balldeep::admin.forms.entries', compact('form', 'entries'));
	}

	public function edit(Form $form)
	{
		return view('balldeep::admin.forms.edit', compact('form'));
	}

	public function update(Form $form, StoreFormRequest $request)
	{
		$form->update($request->only('name'));

		if( $request->get('fields') )
		{
			foreach( $request->get('fields') as $id => $params )
			{
				$required = isset($params['required']) ? 1 : 0;

				$form->fields()->find($id)->update(array_except($params, ['required']) + compact('required'));
			}
		}

		return redirect()->back()->with('success', 'Form successfully updated!');
	}

	public function notifications(Form $form)
	{
		return view('balldeep::admin.forms.notifications', compact('form'));
	}

	public function addField(Form $form, StoreFormFieldRequest $request)
	{
		$field = $form->fields()->create($request->all());

		return response()->json([
			'html' => view('balldeep::admin.forms.builder.field', compact('field'))->render()
		]);
	}

	public function reorderFields(Form $form, Request $request)
	{
		foreach( json_decode($request->get('items')) as $field )
		{
			$form->fields()->find($field->id)->update([
				'order' => $field->order,
			]);
		}

		return response()->json(['fields' => $form->fields]);
	}
}