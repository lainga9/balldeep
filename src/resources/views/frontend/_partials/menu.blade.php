<nav class="nav nav--{!! $slug = str_slug($menu->name) !!}">
	<ul class="nav__menu">
		@foreach( $menu->items()->orderBy('order')->topLevel()->get() as $index => $item )
			@php( $hasChildren = $item->children->isNotEmpty() )
			<li 
				class="nav__item<?php if( $hasChildren ) : ?> dropdown<?php endif; ?>"
			>
				<a 
					href="{!! $hasChildren ? '#' : $item->url() !!}"
					class="nav__link<?php if( $hasChildren ) : ?> dropdown-toggle<?php endif; ?>"
					<?php if( $hasChildren ) : ?>
						data-toggle="dropdown"
					<?php endif; ?>
				>{!! $item->label() !!}</a>

				<?php if( $hasChildren ) : ?>
					<ul class="nav__submenu dropdown-menu {!! $slug !!}-{!! $index !!}">
						<?php foreach( $item->children()->orderBy('order')->get() as $child ) : ?>
							<li class="nav__item">
								<a href="{!! $child->url() !!}" class="nav__link">{!! $child->label() !!}</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		@endforeach
	</ul>
</nav>