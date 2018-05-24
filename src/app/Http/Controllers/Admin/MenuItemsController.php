<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Menu;
use Lainga9\BallDeep\app\MenuItem;
use Lainga9\BallDeep\app\Post;
use Lainga9\BallDeep\app\Http\Requests\StoreMenuItemRequest;

class MenuItemsController extends Controller {

	protected $menu;

	protected $post;

	public function __construct(Menu $menu, Post $post)
	{
		$this->menu = $menu;
		$this->post = $post;
	}

	public function store(Menu $menu, StoreMenuItemRequest $request)
	{
		$item = $menu->items()->create($request->all());

		return redirect()->route('balldeep.admin.menu.manage', $menu)->with('success', 'Menu successfully updated!');
	}

	public function add(Menu $menu, Request $request)
	{
		foreach( $request->get('posts') as $id )
		{
			$menu->items()->create(['post_id' => $id]);
		}

		return redirect()->route('balldeep.admin.menu.manage', $menu)->with('success', 'Menu successfully updated!');
	}

	public function remove(Menu $menu, Request $request)
	{
		if( ! empty($request->get('ids')) )
		{
			$menu->items()->whereIn('id', $request->get('ids'))->delete();
		}

		return redirect()->route('balldeep.admin.menu.manage', $menu)->with('success', 'Menu successfully updated!');
	}

}