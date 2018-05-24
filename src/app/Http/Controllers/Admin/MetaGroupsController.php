<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Http\Requests\StoreMetaFieldRequest;
use Lainga9\BallDeep\app\Http\Requests\StoreMetaGroupRequest;
use Lainga9\BallDeep\app\MetaGroup;
use Lainga9\BallDeep\app\PostType;

class MetaGroupsController extends Controller {

	protected $group;

	protected $type;

	public function __construct(MetaGroup $group, PostType $type)
	{
		$this->group = $group;
		$this->type = $type;
	}

	public function index()
	{
		$groups = $this->group->all();

		return view('balldeep::admin.groups.index', compact('groups'));
	}

	public function create()
	{
		$types = $this->type->all();

		return view('balldeep::admin.groups.create', compact('types'));
	}

	public function edit(MetaGroup $group)
	{
		$types = $this->type->all();

		return view('balldeep::admin.groups.edit', compact('group', 'types'));
	}

	public function store(StoreMetaGroupRequest $request)
	{
		$group = $this->group->create($request->only('name'));

		foreach( $request->get('fields') as $data )
		{
			$group->fields()->create($data);
		}

		$group->postTypes()->sync($request->get('types'));

		return redirect()->route('balldeep.admin.groups.edit', $group)->with('success', 'Group updated!');
	}

	public function update(MetaGroup $group, StoreMetaGroupRequest $request)
	{
		$group->update($request->only('name'));

		foreach( $request->get('fields') as $id => $data )
		{
			$group->fields()->find($id)->update($data);
		}

		$group->postTypes()->sync($request->get('types'));

		return redirect()->back()->with('success', 'Group updated!');		
	}

	public function addField(MetaGroup $group, StoreMetaFieldRequest $request)
	{
		$group->fields()->create($request->all());

		return redirect()->back()->with('success', 'Field added!');
	}

	public function reorderFields(MetaGroup $group, Request $request)
	{
		foreach( json_decode($request->get('items')) as $item )
		{
			$group->fields()->find($item->id)->update(['order' => $item->order]);
		}

		return response()->json(['items' => $group->fields]);
	}
}