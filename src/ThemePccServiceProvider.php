<?php

namespace Ophim\ThemePcc;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemePccServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/pcc')
        ], 'pcc-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'pcc' => [
                'name' => 'Theme Pcc',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-pcc',
                'publishes' => ['pcc-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommended movies limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 24,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 12,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => "Phim bộ mới||type|series|12|/danh-sach/phim-bo\r\nPhim lẻ mới||type|single|12|/danh-sach/phim-bo",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "Top phim lẻ||type|single|view_total|desc|5\r\nTop phim bộ||type|series|view_total|desc|5",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="container-fluid clearfix">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="nav-footer">
                                        <ul id="menuFooter" class="menu-footer">
                                            <li> <a title="Link" href="Link.html">Link</a> </li>
                                            <li> <a title="Link" href="Link.html">Link</a> </li>
                                            <li> <a title="Link" href="Link.html">Link</a> </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="contact_footer col-xs-12 col-sm-12 col-md-2">
                                    <p>Phim mới cập nhật liên tục, Xem phim online chất lượng cao, phim thuyết minh, phim Vietsub.
                                        Cập nhật các bộ phim bom tấn HOT liên tục hàng ngày 24/7</p>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 link-footer">
                                    <p class="title_footer" style="margin-top: 20px;"> Liên hệ </p>
                                    <span>email@</span>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 link-footer">
                                    <p class="title_footer" style="margin-top: 20px;">Thể loại nổi bật</p>
                                    <ul>
                                        <li> <a title="Phim hành động" href="/">Phim hành động</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 link-footer">
                                    <p class="title_footer" style="margin-top: 20px;">Quốc gia nổi bật</p>
                                    <ul>
                                        <li> <a title="Mỹ" href="/">Mỹ</a> </li>
                                    </ul>
                                </div>
                                <div class="col-sx-12 col-sm-2 col-md-2 link-footer">
                                    <p class="title_footer" style="margin-top: 20px;"> Phim Hot </p>
                                    <ul>
                                        <li> <a title="Bác Sĩ Xứ Lạ" href="/">Bác Sĩ Xứ Lạ</a> </li>
                                    </ul>
                                </div>
                                <div class="col-sx-12 col-sm-2 col-md-2 link-footer">
                                    <p class="title_footer" style="margin-top: 20px;"> TextLink </p>
                                    <ul>
                                        <li> <a title="TextLink" href="/">TextLink</a> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
