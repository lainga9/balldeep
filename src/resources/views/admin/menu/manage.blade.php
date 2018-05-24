@extends('balldeep::layout')

@section('title', 'Manage Menu: ' . $menu->name)

@section('content')

	<div class="row pt-4">

		<div class="col-md-4">

			<form action="{!! route('balldeep.admin.menu.items.add', $menu) !!}" method="POST">

				{!! csrf_field() !!}

				@foreach( $types as $type )

					<h6 class="mb-2">{!! str_plural($type->name) !!}</h6>

					<div class="mb-4">

						@if( ! $type->posts->isEmpty() )

							@foreach( $type->posts()->latest()->get() as $post )

								<div>
									<input 
										type="checkbox"
										name="posts[]"
										id="{!! $post->id !!}"
										value="{!! $post->id !!}"
									>
									<label for="{!! $post->id !!}">{!! $post->name !!}</label>
								</div>

							@endforeach

						@else

							No {!! str_plural($type->name) !!}

						@endif
						
					</div>

				@endforeach

				<button type="submit" class="btn btn-primary">Add to Menu</button>
				
			</form>

			<hr class="mb-4 mt-4">

			<h6 class="mb-3">Custom Link</h6>

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
				<button type="submit" class="btn btn-primary">Add to Menu</button>
			</form>
			
		</div>

		<div class="col-md-8">

			@if( $menu->items()->topLevel()->get()->isNotEmpty() )

				<form action="{!! route('balldeep.admin.menu.items.remove', $menu) !!}" method="POST">

					{!! csrf_field() !!}

					<ul class="list list--plain list--menu" data-sortable="{!! route('balldeep.admin.menu.reorder', $menu) !!}">
						@foreach( $menu->items()->topLevel()->orderBy('order')->get() as $item )	
							<li class="list__item" data-id="{!! $item->id !!}">
								<span>{!! $item->label() !!}</span>
								<input 
									type="checkbox"
									name="ids[]"
									id="{!! $item->id !!}"
									value="{!! $item->id !!}"
								>
							</li>
							@foreach( $item->children()->orderBy('order')->get() as $child )
								<li class="list__item sortable-nested" data-id="{!! $child->id !!}">
									<span>{!! $child->label() !!}</span>
									<input 
										type="checkbox"
										name="ids[]"
										id="{!! $child->id !!}"
										value="{!! $child->id !!}"
									>
								</li>
							@endforeach
						@endforeach
					</ul>

					<button type="submit" class="btn btn-danger">Remove Selected</button>

				</form>

			@else

				<div class="alert alert-info">You have not yet added any items to the menu.</div>

			@endif
			
		</div>

	</div>

@stop