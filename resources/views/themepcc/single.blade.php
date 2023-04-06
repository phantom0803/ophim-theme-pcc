@extends('themes::themepcc.layout')

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

            @foreach ($currentMovie->regions as $region)
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="" itemprop="item" href="{{ $region->getUrl() }}" title="{{ $region->name }}">
                        <span itemprop="name">
                            {{ $region->name }}
                        </span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
            @endforeach
            @foreach ($currentMovie->categories as $category)
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="" itemprop="item" href="{{ $category->getUrl() }}" title="{{ $category->name }}">
                        <span itemprop="name">
                            {{ $category->name }}
                        </span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
            @endforeach
            <li class="" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ $currentMovie->getUrl() }}" title="{{ $currentMovie->name }}">
                    <span class="breadcrumb_last" itemprop="name">
                        {{ $currentMovie->name }}
                    </span>
                </a>
                <meta itemprop="position" content="3">
            </li>
        </ol>
    </div>
@endsection

@section('content')
    @if ($currentMovie->notify && $currentMovie->notify != '')
        <div class="bin-bg mt">
            Thông báo: <span class="text-danger">{{ strip_tags($currentMovie->notify) }}</span>
        </div>
    @endif
    @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
        <div class="bin-bg mt">
            Lịch chiếu: <span class="text-info">{!! $currentMovie->showtimes !!}</span>
        </div>
    @endif
    <div class="movie-banner">
        <div class="movie-banner-src lazyload"
            style="background-image:url('{{ $currentMovie->getPosterUrl() }}')"></div>
        <div class="icon-play">
            <a href="" title="{{ $currentMovie->name }}"></a>
        </div>
    </div>
    <div class="movie-info clearfix">
        <div id="before-watching"></div>
        <div class="column-300 pull-left">
            <div class="thumbnail mb-none">
                <img class="info-poster-img" src="{{ $currentMovie->getThumbUrl() }}" alt="{{ $currentMovie->name }}" />
            </div>
            <div class="button-play">
                @if ($currentMovie->trailer_url)
                    <a class="btn btn-blue btn-rounded" title="Trailer {{ $currentMovie->name }}"
                        href="javascript:trailer()"> <i class="sp-movie-icon-camera"></i> Trailer </a>
                @endif
                {{-- optimize sau --}}
                @if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '')
                    <a class="btn btn-red btn-rounded" title="Xem phim {{ $currentMovie->name }}"
                        href="{{ $currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server')->first()->sortByDesc('name', SORT_NATURAL)->groupBy('name')->last()->sortByDesc('type')->first()->getUrl() }}">
                        <i class="sp-movie-icon-camera"></i> Xem Phim </a>
                @endif
            </div>
            <div class="block mt-xl">
                <div class="weight-normal font-24">
                    <i class="sp-movie-icon-film"></i> Thông tin
                </div>
                <div class="block-content movie-info-sidebar bin-bg">
                    <ul class="list-style-none list-inline">
                        <li class="common-list">
                            <span> Trạng Thái:</span>
                            <font color="red">{{ $currentMovie->episode_current }}</font>
                        </li>
                        <li class="common-list">
                            <span> Tổng số tập:</span>
                            {{ $currentMovie->episode_total }}
                        </li>
                        <li class="common-list">
                            <span> Thể loại:</span>
                            {!! $currentMovie->categories->map(function ($category) {
                                    return '<a href="' .
                                        $category->getUrl() .
                                        '" title="' .
                                        $category->name .
                                        '"><span>' .
                                        $category->name .
                                        '</span></a>';
                                })->implode(', ') !!}
                        </li>
                        <li class="common-list">
                            <span> Quốc gia:</span>
                            {!! $currentMovie->regions->map(function ($region) {
                                    return '<a href="' .
                                        $region->getUrl() .
                                        '" title="' .
                                        $region->name .
                                        '"><span>' .
                                        $region->name .
                                        '</span></a>';
                                })->implode(', ') !!}
                        </li>
                        <li class="common-list">
                            <span> Năm phát hành: </span> {{ $currentMovie->publish_year }}
                        </li>
                        <li class="common-list">
                            <span> Đạo diễn:</span>
                            <span itemprop="director">
                                {!! $currentMovie->directors->map(function ($director) {
                                        return '<a class="director" href="' .
                                            $director->getUrl() .
                                            '" title="' .
                                            $director->name .
                                            '"><span>' .
                                            $director->name .
                                            '</span></a>';
                                    })->implode(', ') !!}
                            </span>
                        </li>
                        <li class="common-list">
                            <span> Thời lượng:</span> {{ $currentMovie->episode_time ?? 'N/A' }}
                        </li>
                        <li class="common-list">
                            <span> Lượt xem:</span> {{ $currentMovie->view_total }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ads ads-info-left"></div>
        </div>
        <div class="column-with-300 pull-right">
            <div class="movie-info-top">
                <h2 class="movie-title">{{ $currentMovie->name }}</h2>
                <div class="movie-subtitle">{{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</div>
                <div class="movie-rating">
                    <div id="movies-rating-star"></div>
                    ({{$currentMovie->getRatingStar()}}
                    sao
                    /
                    {{$currentMovie->getRatingCount()}} đánh giá)
                    <span class="hint" id="movies-rating-msg"></span>
                    <div class="rate-star">
                        <i class="sp-movie-icon-star-line"></i>
                        <span class="avg_vote">{{$currentMovie->getRatingStar()}}</span>
                    </div>
                </div>
            </div>
            <div id="hidden-download">
                <div class="block mt-xl">
                    <div class="block-heading">
                        <h2 class="block-title weight-normal text-blue">
                            <i class="sp-movie-icon-book"></i>
                            <span class="text_dv">Giới thiệu</span>
                        </h2>
                    </div>
                    <div class="block-content bin-bg">
                        <div class="page-content mt">
                            <div class="content_film">
                                @if ($currentMovie->content)
                                    {!! $currentMovie->content !!}
                                @else
                                    Nội dung đang được cập nhật...
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($currentMovie->actors))
                    <div class="block mt-xl">
                        <div class="block-heading">
                            <h2 class="block-title weight-normal">
                                <i class="sp-movie-icon-user-review"></i>
                                <span class="text_dv">Diễn viên</span>
                            </h2>
                        </div>
                        <div class="block-content list-actor bin-bg">
                            <div class="items clearfix">
                                {!! $currentMovie->actors->map(function ($actor) {
                                        return '<div class="item">
                                                                                                                                                                    <div class="item-inner">
                                                                                                                                                                        <a href="' .
                                            $actor->getUrl() .
                                            '" class="actor-ava"
                                                                                                                                                                            style="background-image: url(\'/themes/pcc/images/dienvien.png\')"
                                                                                                                                                                            title="' .
                                            $actor->name .
                                            '"></a>
                                                                                                                                                                        <h3 class="actor-info">
                                                                                                                                                                            <a href="" title="' .
                                            $actor->name .
                                            '">' .
                                            $actor->name .
                                            '</a>
                                                                                                                                                                        </h3>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>';
                                    })->implode('') !!}
                            </div>
                        </div>
                    </div>
                @endif
                @if ($currentMovie->trailer_url)
                    @php
                        parse_str(parse_url($currentMovie->trailer_url, PHP_URL_QUERY), $parse_url);
                        $trailer_id = $parse_url['v'];
                    @endphp
                    <div id="trailer" class="block mt-xl">
                        <div class="block-heading">
                            <h2 class="block-title weight-normal"><i class="sp-movie-icon-videocam text-danger"></i><span
                                    class="text_dv">Trailers &amp; Videos</span></h2>
                        </div>
                        <div class="block-content bin-bg">
                            <div class="row fix-row row-trailer">
                                <div class="col-md-12">
                                    <div class="trailer">
                                        <div class="trailer-image-wrap">
                                            <img class="lazyload lazy-loaded"
                                                data-src="https://img.youtube.com/vi/{{ $trailer_id }}/sddefault.jpg"
                                                alt="trailers">
                                            <div class="icon-play"> <a href="javascript:void(0);" rel="nofollow"
                                                    data-id="{{ $trailer_id }}"> <i class="sp-movie-icon-play"></i>
                                                </a> </div>
                                        </div>
                                        <div class="trailer-info">
                                            <div class="trailer-info-block">
                                                <h3>{{ $currentMovie->name }}</h3>
                                                <p class="genry">
                                                    {!! $currentMovie->categories->map(function ($category) {
                                                            return '<a href="' .
                                                                $category->getUrl() .
                                                                '" title="' .
                                                                $category->name .
                                                                '"><span>' .
                                                                $category->name .
                                                                '</span></a>';
                                                        })->implode(', ') !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="fb-comment-watching">
                    <div class="block mt-xl">
                        <div class="block-heading">
                            <div class="block-title weight-normal text-pink">
                                <i class="sp-movie-icon-user-review"></i>
                                <span class="text_dv">Bình luận</span>
                            </div>
                        </div>
                        <div class="block-content pt bin-bg">
                            <div class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                                data-num-posts="5"></div>
                        </div>
                    </div>
                </div>
                <div class="block mt-xl">
                    <div class="block-heading">
                        <h3 class="block-title weight-normal text-pink">
                            <i class="sp-movie-icon-user-review text-pink"></i>
                            <span class="text_dv">Phim liên quan</span>
                        </h3>
                    </div>
                    <div class="block-content pt">
                        <div id="recoment-films" class="block-items row fix-row">
                            @foreach ($movie_related ?? [] as $movie)
                                @include('themes::themepcc.inc.block_movies.block_movies_item')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/themes/pcc/libs/jquery-raty/jquery.raty.js"></script>
    <link href="/themes/pcc/libs/jquery-raty/jquery.raty.css" rel="stylesheet" type="text/css" />

    <script>
        var rated = false;
        $('#movies-rating-star').raty({
            score: {{$currentMovie->getRatingStar()}},
            number: 10,
            numberMax: 10,
            hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                'rất hay', 'siêu phẩm'
            ],
            starOff: '/themes/pcc/libs/jquery-raty/images/star-off.png',
            starOn: '/themes/pcc/libs/jquery-raty/images/star-on.png',
            starHalf: '/themes/pcc/libs/jquery-raty/images/star-half.png',
            click: function(score, evt) {
                if (rated) return
                fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    },
                    body: JSON.stringify({
                        rating: score
                    })
                });
                rated = true;
                $('#movies-rating-star').data('raty').readOnly(true);
                $('#movies-rating-msg').html(`Bạn đã đánh giá ${score} sao cho phim này!`);
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
