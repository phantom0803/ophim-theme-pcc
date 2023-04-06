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
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ $currentMovie->getUrl() }}" title="{{ $currentMovie->name }}">
                    <span itemprop="name">
                        {{ $currentMovie->name }}
                    </span>
                </a>
                <meta itemprop="position" content="3">
            </li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ url()->current() }}" title="Tập {{ $episode->name }}">
                    <span class="breadcrumb_last" itemprop="name">
                        Tập {{ $episode->name }}
                    </span>
                </a>
                <meta itemprop="position" content="4">
            </li>
        </ol>
    </div>
    <div id="zoomPlayer"></div>
@endsection

@section('content')
    @if ($currentMovie->notify && $currentMovie->notify != '')
        <div class="bin-bg mb">
            Thông báo: <span class="text-danger">{{ strip_tags($currentMovie->notify) }}</span>
        </div>
    @endif
    @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
        <div class="bin-bg mb">
            Lịch chiếu: <span class="text-info">{!! $currentMovie->showtimes !!}</span>
        </div>
    @endif
    <div id="normalPlayer">
        <div id="pl-content">
            <div class="player-wrapper">
                <div class="player-container">
                    <div class="embed-responsive embed-responsive-16by9 sixteen-nine">
                        <div class="embed-responsive-item">
                            <div id="media-player-box" style="height: 100%;">
                            </div>
                            <div class="box_loading_player" style="display: block;"></div>
                        </div>
                    </div>
                    <div class="mt clearfix">
                        <center>
                            <ul class="server-list">
                                <li class="backup-server"> <span class="server-title">Đổi Sever</span>
                                    <ul class="list-episode">
                                        <li class="episode">
                                            @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                                <a data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                                    data-type="{{ $server->type }}" onclick="chooseStreamingServer(this)"
                                                    class="streaming-server btn-link-backup btn-episode black episode-link">VIP
                                                    #{{ $loop->index + 1 }}</a>
                                            @endforeach
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </center>
                    </div>
                    <div class="mt clearfix">
                        <div class="pull-left">
                            <div id="lightOff" style="display: none;"></div> <a
                                class="btn btn-default btn-rounded btn-yellow" title="Tắt đèn" href="javascript:();"
                                id="lightBtn"> <i class="fa fa-lightbulb-o"></i> Tắt đèn</a> <a style="margin-left: 5px;"
                                class="btn btn-default btn-rounded btn-yellow" onclick="ZoomToggle();" id="zoomBtn"> <i
                                    class="fa fa-arrows-h"></i>
                                Phóng to </a>
                            <button style="margin-left: 5px;" class="btn btn-default btn-rounded btn-yellow bp-btn-error"
                                id="btn-toggle-error" title="Báo lỗi phim {{ $currentMovie->name }}" href="#"> <i
                                    class="fa fa-warning"></i> Báo lỗi </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-servers">
                <div class="block-heading">
                    <h2 class="block-title weight-normal text-blue"> <i class="fa fa-film"></i> <a
                            href="{{ $currentMovie->getUrl() }}">{{ $currentMovie->name }} </a> </h2>
                    <div class="movie-rating">
                        <div id="movies-rating-star"></div>
                        ({{$currentMovie->getRatingStar()}}
                        sao
                        /
                        {{$currentMovie->getRatingCount()}} đánh giá)
                        <span class="hint" id="movies-rating-msg"></span>
                    </div>
                </div>
                @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                    <div class="server-name"><i class="sp-movie-icon-camera"></i> {{ $server }}</div>
                    <div class="list-episodes">
                        <div class="episodes mCustomScrollbar _mCS_{{ $loop->index }} mCS_no_scrollbar">
                            <div id="mCSB_{{ $loop->index }}"
                                class="mCustomScrollBox mCS-light-thin mCSB_vertical mCSB_inside">
                                <div id="mCSB_{{ $loop->index }}_container"
                                    class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y">
                                    @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                        <a class="btn btn-rounded {{ $item->contains($episode) ? 'btn-deep-orange' : 'btn-dark' }}"
                                            title="{{ $name }}"
                                            href="{{ $item->sortByDesc('type')->first()->getUrl() }}">{{ $name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="movie-info clearfix" style="margin-top: 0;">
        <div id="before-watching">
            <div id="watching">
                <div id="fb-comment-before-watching">
                    <div id="fb-comment-watching">
                        <div class="block mt-xl">
                            <div class="block-heading">
                                <h4 class="block-title weight-normal text-pink"><i
                                        class="sp-movie-icon-user-review"></i><span class="text_dv">Bình luận</span></h4>
                            </div>
                            <div class="block-content pt">
                                <div class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                                    data-num-posts="5"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="hidden-download">
                    <div class="block mt-xl">
                        <h3 class="block-title weight-normal text-pink">
                            <i class="sp-movie-icon-user-review text-pink"></i><span class="text_dv">Phim liên quan</span>
                        </h3>
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
    </div>
@endsection

@push('scripts')
    <script src="/themes/pcc/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/pcc/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('#media-player-box').offset().top - 40
            }, 'slow');
        });
    </script>

    <script>
        var episode_id = {{$episode->id}};
        const wrapper = document.getElementById('media-player-box');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active');
            })
            el.classList.add('active');

            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            $(".box_loading_player").hide();
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/pcc/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{$episode->id}}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <script>
        $("#btn-toggle-error").click(() => {
            fetch("{{ route('episodes.report', ['movie' => $currentMovie->slug, 'episode' => $episode->slug, 'id' => $episode->id]) }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    message: ''
                })
            });
            $("#btn-toggle-error").remove();
        })
    </script>


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
