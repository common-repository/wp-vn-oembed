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

namespace VN_OEmbed\Handler;


class TVZing extends Base{
	public function __construct(){
		parent::__construct('#https?:\/\/(www\.)?tv\.zing\.vn\/(video)\/([a-zA-Z\-\d]+)\/([a-zA-Z\d]*)\.html#i');
	}
	public function generateEmbedCode($matches, $attr, $url, $rawattr){
		$embed = $url;
		$pattern = '';
		switch ($matches[2]) {
			case 'video':
				$pattern = '<iframe width="560" height="315" src="http://tv.zing.vn/embed/video/%1$s" frameborder="0" allowfullscreen="true"> </iframe>';
				break;
		}
		if ($pattern) {
			$embed = sprintf(
				$pattern,
				esc_attr($matches[4])
			);
		}
		return $embed;
	}
}
