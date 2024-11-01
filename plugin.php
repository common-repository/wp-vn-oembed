<?php
/*
Plugin Name: Wordpress VN oEmbed
Version: 1.1.2
Description: Tự động nhúng nhạc, video, clip từ các trang nhạc ở Việt Nam. Bạn có thể xem hướng dẫn tại đây <a href="http://laptrinh.senviet.org/wordpress-plugin/wordpress-oembed-ho-tro-cho-cac-trang-nhac/">Hướng dẫn</a>
Author: Nguyễn Văn Được
Author URI: http://laptrinh.senviet.org
Plugin URI: http://laptrinh.senviet.org
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags:music, nhạc, oembed, post, plugin



*/
define('VNO_DIR', __DIR__);
define('VNO_BASENAME', plugin_basename( __FILE__ ));

include_once VNO_DIR. '/bootstrap.php';

global $vno_ruler_factory;
$vno_ruler_factory = new \VN_OEmbed\Factory();

if(is_admin()){
	new \VN_OEmbed\Admin();
}
