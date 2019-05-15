<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            @auth('admin')
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {{--<span><img alt="image" class="img-circle" src="{{ skinPath() }}images/profile_small.jpg" /></span>--}}
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">{{ auth()->user()->truename }}</strong></span>
                            <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a class="J_menuItem" href="profile.html">个人资料</a>
                        </li>
                        <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                        </li>
                        <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}">安全退出</a></li>
                    </ul>
                </div>
                <div class="logo-element">LS
                </div>
            </li>
            @endauth
            @foreach ($menus as $menu)
            <li>
                <a class="J_menuItem" href="{{ !empty($menu['child']) ? '' : $menu['url'] }}">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span class="nav-label">{{ $menu['name'] }}</span>
                    @if(!empty($menu['child']))
                    <span class="fa arrow"></span>
                    @endif
                </a>
                @if(!empty($menu['child']))
                <ul class="nav nav-second-level">
                    @foreach ($menu['child'] as $ck => $cv)
                    <li>
                        <a class="J_menuItem" href="{{ $cv['url'] }}" data-index="0">{{ $cv['name'] }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>