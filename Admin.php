<?php
/**
 * Summary
 *
 * Description.
 *
 * @since 0.9.0
 *
 * @package
 * @subpackage 
 *
 * @author nguyenvanduocit
 */

namespace VN_OEmbed;


class Admin {
	public function __construct(){
		add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 4);
	}
	public function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status){
		if($plugin_file === VNO_BASENAME)
		{
			$plugin_meta[] = '<a href="http://laptrinh.senviet.org"><strong>Hướng dẫn lập trình</strong></a>';
			$plugin_meta[] = '<a href="http://wordpresskite.com" style="color: rgba(251, 0, 0, 0.75)"><strong>Lập trình WordPress</strong></a>';
		}
		return $plugin_meta;
	}
}