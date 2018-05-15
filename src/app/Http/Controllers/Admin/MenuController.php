<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Menu;
use Lainga9\BallDeep\app\Http\Requests\StoreMenuRequest;

class MenuController extends Controller {

	protected $menu;

	public function __construct(Menu $menu)
	{
		$this->menu = $menu;
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
		return view('balldeep::admin.menu.manage', compact('menu'));
	}

	public function reorder(Menu $menu, Request $request)
	{
		foreach( json_decode($request->get('items')) as $item )
		{
			$model = $menu->items()->find($item->id);

			$model->update(['order' => $item->order]);
		}
	}	

	public function delete(Menu $menu)
	{
		$menu->items()->delete();

		$menu->delete();

		return redirect()->route('balldeep.admin.menu.index')->with('success', 'Menu successfully deleted!');
	}
}