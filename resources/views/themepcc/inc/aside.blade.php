<div class="right-sidebar column-300">
    @foreach ($tops as $top)
        <div class="block" id="sidebar">
            <div class="block-heading" style="border: none;">
                <div class="block-title">
                    <i class="fa fa-star"></i> {{ $top['label'] }}
                </div>
            </div>
            <div class="box-asian-tabs tab-remote-sidebar">
                <ul class="nav nav-tabs nav-justified"></ul>
                <div class="tab-content p-none block-single list_data_tab_pb" style="position: static; zoom: 1;">
                    <div class="content-tab-sidebar" id="owl-slide">
                        <ul class="list-group list-group-movie clearfix">
                            @foreach ($top['data'] as $movie)
                                <li class="list-group-item clearfix">
                                    <div class="thumbnail">
                                        <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}">
                                            <img data-src="{{ $movie->getThumbUrl() }}" class="lazyload" alt="{{ $movie->name }}" />
                                        </a>
                                    </div>
                                    <div class="meta-item">
                                        <h3 class="name-1">
                                            <a href="{{ $movie->getUrl() }}"
                                                title="{{ $movie->name }}">{{ $movie->name }}</a>
                                        </h3>
                                        <h4 class="name-2">{{ $movie->origin_name }} ({{ $movie->publish_year }})</h4>
                                        <p>{{ $movie->episode_current }}</p>
                                        <p>
                                            <i class="fa fa-video-camera"></i> {{ $movie->view_week }} lượt xem
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
