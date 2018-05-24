<aside class="bd-sidebar">

    <nav class="bd-sidebar__nav">
        <ul class="bd-sidebar__nav-menu">

            @can('manage-menus')
                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.menu.index') !!}"><i class="bd-sidebar__nav-icon fa fa-bars"></i> Menus</a>
                </li>
            @endcan

            <li class="bd-sidebar__nav-item">
                <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.media.index') !!}"><i class="bd-sidebar__nav-icon fa fa-images"></i> Media</a>
            </li>

            @foreach( Lainga9\BallDeep\app\PostType::all() as $type )

                @can('browse', $type)

                    <li class="bd-sidebar__nav-item">
                        <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.posts.index', $type) !!}"><i class="bd-sidebar__nav-icon fa fa-edit"></i> {!! str_plural($type->name) !!}</a>
                    </li>

                @endcan

            @endforeach

            @can('manage-users')

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.groups.index') !!}"><i class="bd-sidebar__nav-icon fa fa-star"></i> Custom Fields</a>
                </li>

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.users.index') !!}"><i class="bd-sidebar__nav-icon fa fa-users"></i> Users</a>
                </li>

            @endcan  
        </ul>
    </nav>
    
</aside>