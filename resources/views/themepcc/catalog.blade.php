@extends('themes::themepcc.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

@section('breadcrumb')
    <div class="container-wrapper">
        <ol class="breadcrumb clearfix" itemScope itemType="https://schema.org/BreadcrumbList">
            <li itemProp="itemListElement" itemScope itemType="http://schema.org/ListItem">
                <a class="" itemProp="item" title="Xem phim" href="/">
                    <span class="" itemProp="name">
                        Xem phim
                    </span>
                    <meta itemProp="position" content="1" />
                </a>
            </li>

            <li class="" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ url()->current() }}" title="{{ $section_name ?? 'Danh Sách Phim' }}">
                    <span class="breadcrumb_last" itemprop="name">
                        {{ $section_name ?? 'Danh Sách Phim' }}
                    </span>
                </a>
                <meta itemprop="position" content="2">
            </li>
        </ol>
    </div>
@endsection

@section('content')
    @include('themes::themepcc.inc.catalog_filter')
    <div class="block">
        <div class="block-heading with-tabs">
            <div class="block-title">
                <h2 class="block-title"><i class="sp-movie-icon-videocam"></i> {{ $section_name }}</h2>
            </div>
        </div>
        <div class="block-content">
            <div class="block-items row fix-row">
                @if (count($data))
                    @foreach ($data as $movie)
                        @include('themes::themepcc.inc.block_movies.block_movies_item')
                    @endforeach
                @else
                    <div class="item">Rất tiếc, không có nội dung nào trùng khớp yêu cầu.</div>
                @endif
            </div>
            <div class="text-center">
                {{ $data->appends(request()->all())->links('themes::themepcc.inc.pagination') }}
            </div>
        </div>
    </div>

@endsection
