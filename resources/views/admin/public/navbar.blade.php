<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="{{ auth()->guard('admin')->user()->avatar }}" width="64"/></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">{{ auth()->guard('admin')->user()->truename }}</strong></span>
                            <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="">修改头像</a></li>
                        <li><a class="J_menuItem" href="">个人资料</a></li>
                        <li><a class="J_menuItem" href="">联系我们</a></li>
                        <li><a class="J_menuItem" href="">信箱</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout.get') }}">安全退出</a></li>
                    </ul>
                </div>
                <div class="logo-element">SCMS</div>
            </li>
            @foreach ($menus as $menu)
            <li>
                <a class="J_menuItem" href="{{ empty($menu['child']) ? $menu['url'] : '' }}">
                    <i class="{{ $menu['ico'] }}"></i>
                    <span class="nav-label">{{ $menu['name'] }}</span>
                    @if (!empty($menu['child']))
                    <span class="fa arrow"></span>
                    @endif
                </a>
                @if (!empty($menu['child']))
                <ul class="nav nav-second-level">
                    @foreach ($menu['child'] as $cmenu)
                    <li>
                        <a class="J_menuItem" href="{{ $cmenu['url'] }}" data-index="0">{{ $cmenu['name'] }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>