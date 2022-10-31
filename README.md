# THEME - PCC 2022 - OPHIM CMS

## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/rmm3qdM/PCC-INDEX.png "Home Page")

### Trang Danh Sách Phim
![Alt text](https://i.ibb.co/X5cjQQt/PCC-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim
![Alt text](https://i.ibb.co/rfP5Rn7/PCC-SINGLE.png "Single Page")

### Trang Xem Phim
![Alt text](https://i.ibb.co/mCB8c5X/PCC-EPISODE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-pcc`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-pcc`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes
    
## Document
### List
- Trang chủ: `display_label|relation|find_by_field|value|limit|show_more_url`
    + Ví dụ theo định dạng: `Phim bộ mới||type|series|12|/danh-sach/phim-bo`
    + Ví dụ theo định dạng: `Phim lẻ mới||type|single|12|/danh-sach/phim-bo`
    + Ví dụ theo thể loại: `Phim hành động|categories|slug|hanh-dong|12|/the-loai/hanh-dong`
    + Ví dụ theo quốc gia: `Phim hàn quốc|regions|slug|han-quoc|12|/quoc-gia/han-quoc`
    + Ví dụ với các field khác: `Phim chiếu rạp||is_shown_in_theater|1|12|`

- Danh sách hot:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit`
    + `Phim sắp chiếu||status|trailer|publish_year|desc|9`
    + `Top phim bộ||type|series|view_total|desc|9`
    + `Top phim lẻ||type|single|view_total|desc|9`

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-pcc/resources/views/themepcc`
- Copy file cần custom đến: `/resources/views/vendor/themes/themepcc`
