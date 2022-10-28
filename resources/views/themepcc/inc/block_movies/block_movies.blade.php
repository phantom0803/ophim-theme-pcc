<div class="block">
    <div class="block-heading with-tabs">
        <div class="block-title">
            <h2 class="block-title"><i class="sp-movie-icon-videocam"></i> {{$item['label'] ?? ''}}</h2>
        </div>
        <div class="box-asian-tabs">
            <ul class="nav nav-tabs">
                <li role="presentation">
                    <a href="{{$item['link'] ?? ''}}" class="film-tab-type" title="{{$item['label'] ?? ''}}">Xem thêm</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="block-content">
        <div class="block-items row fix-row">
            @foreach ($item['data'] ?? [] as $movie)
                @include('themes::themepcc.inc.block_movies.block_movies_item')
            @endforeach
        </div>
    </div>
</div>
