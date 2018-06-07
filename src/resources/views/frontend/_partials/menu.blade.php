<nav class="bd-nav bd-nav--{!! $slug = str_slug($menu->name) !!}<?php if(isset($params['container_class'])) : ?> <?php echo $params['container_class']; ?><?php endif; ?>">
	<ul class="bd-nav__menu<?php if(isset($params['menu_class'])) : ?> <?php echo $params['menu_class']; ?><?php endif; ?>">
		@foreach( $menu->items()->orderBy('order')->topLevel()->get() as $index => $item )
			@php( $hasChildren = $item->children->isNotEmpty() )
			<li 
				class="bd-nav__item<?php if( $hasChildren ) : ?> dropdown<?php endif; ?><?php if(isset($params['item_class'])) : ?> <?php echo $params['item_class']; ?><?php endif; ?>"
			>
				<a 
					href="{!! $hasChildren ? '#' : $item->url() !!}"
					class="bd-nav__link<?php if( $hasChildren ) : ?> dropdown-toggle<?php endif; ?><?php if(isset($params['link_class'])) : ?> <?php echo $params['link_class']; ?><?php endif; ?>"
					<?php if( $hasChildren ) : ?>
						data-toggle="dropdown"
					<?php endif; ?>
				>{!! $item->label() !!}</a>

				<?php if( $hasChildren ) : ?>
					<ul class="bd-nav__submenu dropdown-menu {!! $slug !!}-{!! $index !!}">
						<?php foreach( $item->children()->orderBy('order')->get() as $child ) : ?>
							<li class="bd-nav__item">
								<a href="{!! $child->url() !!}" class="bd-nav__link">{!! $child->label() !!}</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		@endforeach
	</ul>
</nav>