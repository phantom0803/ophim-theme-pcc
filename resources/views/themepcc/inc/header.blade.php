@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header id="header" class="clearfix hidden-sm hidden-xs">
    <nav class="header-top navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid clearfix">
            <div class="d-none d-md-block">
                <div class="lh-25 font-13 d-flex d-lg-flex flex-nowrap">
                    <div class="right-hel">
                        <div class="ml-auto align-self-center">
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-table">
                <div class="navbar-cell tight">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/" title="{{ $title }}">
                            @if ($logo)
                                {!! $logo !!}
                            @else
                                {!! $brand !!}
                            @endif
                        </a>
                        <span style="width: 100%;"></span>
                        <div>
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
                                <span class="fa fa-bars"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="navbar-cell stretch navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @foreach ($menu as $item)
                            @if (count($item['children']))
                                <li class="dropdown mega-dropdown has-submenu">
                                    <a href="javascript:;" title="{{ $item['name'] }}">{{ $item['name'] }} <i
                                            class="sp-movie-icon-down"></i></a>
                                    <ul class="dropdown-menu mega-dropdown-menu clearfix with-column-3-200"
                                        role="menu">
                                        @foreach ($item['children'] as $children)
                                            <li> <a href="{{ $children['link'] }}"
                                                    title="{{ $children['name'] }}">{{ $children['name'] }}</a> </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="">
                                    <a href="{{ $item['link'] }}" title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="navbar-cell stretch">
                    <form method="GET" class="form-search" action="/">
                        <div class="input-group mb-sm">
                            <input type="text" class="form-control input-search desktop" name="search"
                                placeholder="Tìm kiếm phim..." value="{{ request('search') }}">
                            <span class="input-group-addon btn-search"> <i class="fa fa-search"></i></span>
                        </div>
                    </form>
                </div>
                <div class="navbar-cell stretch">
                    <div class="user-acount">
                        <div id="top-user"></div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="sb-slidebar sb-left">
    <ul class="nav navbar-nav">
        @foreach ($menu as $item)
            @if (count($item['children']))
                <li class="dropdown mega-dropdown has-submenu">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                        title="{{ $item['name'] }}">{{ $item['name'] }} <i class="sp-movie-icon-down"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($item['children'] as $children)
                            <li> <a href="{{ $children['link'] }}"
                                    title="{{ $children['name'] }}">{{ $children['name'] }}</a> </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="">
                    <a href="{{ $item['link'] }}" class="dropdown-toggle" data-toggle="dropdown"
                        title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<div id="mobile-header" class="visible-sm visible-xs sb-slide">
    <form method="post" class="form-search">
        <div class="input-group input-group-lg">
            <input type="text" class="form-control input-search mobile" name="search" placeholder="Tìm kiếm phim..."
                value="{{ request('search') }}">
            <span class="input-group-addon btn-search"> <i class="fa fa-search"></i> </span>
        </div>
    </form>
    <div class="navbar-table">
        <div class="navbar-cell tight">
            <div class="sb-toggle-left navbar-left"><i class="fa fa-bars"></i></div>
            <a class="sb-header-text" href="/" title="{{ $title }}">
                @if ($logo)
                    {!! $logo !!}
                @else
                    {!! $brand !!}
                @endif
            </a>
            <div class="open-search navbar-right"><i class="fa fa-search"></i></div>
            <div class="user-acount mobile">
                <div id="top-user"></div>
            </div>
        </div>
    </div>
</div>
