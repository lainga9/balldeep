<aside class="bd-sidebar">

    <nav class="bd-sidebar__nav">
        <ul class="bd-sidebar__nav-menu">

            @if( Gate::forUser(Auth::guard('balldeep')->user())->allows('manage-menus') )
                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.menu.index') !!}"><i class="bd-sidebar__nav-icon fa fa-bars"></i> Menus</a>
                </li>
            @endif

            @if( Gate::forUser(Auth::guard('balldeep')->user())->allows('manage-media') )

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.media.index') !!}"><i class="bd-sidebar__nav-icon fa fa-images"></i> Media</a>
                </li>

            @endif

            @foreach( Lainga9\BallDeep\app\PostType::all() as $type )

                @if( Auth::guard('balldeep')->user()->can('browse', $type) )

                    <li class="bd-sidebar__nav-item">
                        <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.posts.index', $type) !!}"><i class="bd-sidebar__nav-icon fa fa-edit"></i> {!! str_plural($type->name) !!}</a>
                    </li>

                @endcan

            @endforeach

            @if( Gate::forUser(Auth::guard('balldeep')->user())->allows('manage-forms') )

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.forms.index') !!}"><i class="bd-sidebar__nav-icon fa fa-envelope"></i> Forms</a>
                </li>

            @endif

            @if( Gate::forUser(Auth::guard('balldeep')->user())->allows('manage-users') )

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.groups.index') !!}"><i class="bd-sidebar__nav-icon fa fa-star"></i> Custom Fields</a>
                </li>

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.users.index') !!}"><i class="bd-sidebar__nav-icon fa fa-users"></i> Users</a>
                </li>

            @endcan

            @if( Gate::forUser(Auth::guard('balldeep')->user())->allows('manage-menus') )

                <li class="bd-sidebar__nav-item">
                    <a class="bd-sidebar__nav-link" href="{!! route('balldeep.admin.settings.index') !!}"><i class="bd-sidebar__nav-icon fa fa-cogs"></i> Settings</a>
                </li>

            @endif

            <li class="bd-sidebar__nav-item">
                <a class="bd-sidebar__nav-link" href="{!! route('balldeep.logout') !!}"><i class="bd-sidebar__nav-icon fa fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </nav>
    
</aside>