@extends('balldeep::layout')

@section('content')

	@if( $menu->items->isNotEmpty() )

		<ul data-sortable="{!! route('balldeep.admin.menu.reorder', $menu) !!}">
			@foreach( $menu->items()->orderBy('order')->get() as $item )	
				<li data-id="{!! $item->id !!}">
					{!! $item->label !!} {!! $item->url !!}
					<ul class="children" data-sortable="{!! route('balldeep.admin.menu.reorder', $menu) !!}">
						<li>Test</li>
					</ul>
				</li>
			@endforeach
		</ul>

	@else

		<div class="alert alert-info">You have not yet added any items to the menu.</div>

	@endif

	<form action="{!! route('balldeep.admin.menu.items.store', $menu) !!}" method="POST">
		{!! csrf_field() !!}
		<div class="form-group">
			<label class="form-label">Label</label>
			<input type="text" name="label" class="form-control">
		</div>
		<div class="form-group">
			<label class="form-label">URL</label>
			<input type="text" name="url" class="form-control">
		</div>
		<button type="submit" class="btn btn-primary">Save Menu Item</button>
	</form>

@stop