@if (count($recommendations))
    <section id="content">
        <div class="container-fluid clearfix">
            <div class="block">
                <div class="block-heading with-tabs">
                    <div class="block-title">
                        <h2 class="block-title"><i class="sp-movie-icon-cup"></i> Phim Hay Đề Cử</h2>
                    </div>
                </div>
                <div class="block-content">
                    <div id="owl-slide" class="row-fluid">
                        <div id="phim-hay" class="block-items row fix-row">
                            @foreach ($recommendations as $movie)
                                <div class="item">
                                    <a class="inner" href="{{ $movie->getUrl() }}" title="{{$movie->name}}">
                                        <img data-src="{{$movie->getThumbUrl()}}" alt="{{$movie->name}}" class="lazyload movie-thumb" />
                                        <span class="thumb-icon"><i class="sp-movie-icon-play"></i> </span>
                                        <span class="overlay"></span>
                                        <div class="description">
                                            <h3 class="text-nowrap">{{$movie->name}}</h3>
                                            <div class="meta clearfix">
                                                <span class="pull-left">{{$movie->publish_year}}</span>
                                                <span class="pull-right">{{$movie->episode_current}}</span>
                                            </div>
                                        </div>
                                        <span class="badge">{{$movie->quality}} {{$movie->language}}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
