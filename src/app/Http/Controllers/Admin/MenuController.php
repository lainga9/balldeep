<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Menu;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Http\Requests\StoreMenuRequest;

class MenuController extends Controller {

	protected $menu;

	protected $type;

	public function __construct(Menu $menu, PostType $type)
	{
		$this->menu = $menu;
		$this->type = $type;
	}

	public function index()
	{
		$menus = $this->menu->all();

		return view('balldeep::admin.menu.index', compact('menus'));
	}

	public function create()
	{
		return view('balldeep::admin.menu.create');
	}

	public function store(StoreMenuRequest $request)
	{
		$menu = $this->menu->create($request->all());

		return redirect()->route('balldeep.admin.menu.index')->with('success', 'Menu successfully stored!');
	}

	public function manage(Menu $menu)
	{
		$types = $this->type->alphabetical()->get();

		return view('balldeep::admin.menu.manage', compact('menu', 'types'));
	}

	public function reorder(Menu $menu, Request $request)
	{
		foreach( json_decode($request->get('items')) as $item )
		{
			$model = $menu->items()->find($item->id);

			$model->update([
				'order' => $item->order,
				'parent'=> $item->parent
			]);
		}

		return response()->json(['items' => $menu->items]);
	}	

	public function delete(Menu $menu)
	{
		$menu->items()->delete();

		$menu->delete();

		return redirect()->route('balldeep.admin.menu.index')->with('success', 'Menu successfully deleted!');
	}
}