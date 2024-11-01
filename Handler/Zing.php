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


class Zing extends Base{
	public function __construct(){
		parent::__construct('#https?:\/\/(www\.)?mp3\.zing\.vn\/(bai-hat|video-clip|album|playlist)\/([a-zA-Z\-\d]+)\/([a-zA-Z\d]*)\.html#i');
	}
	public function generateEmbedCode($matches, $attr, $url, $rawattr){
		$embed = $url;
		$pattern = '';
		switch ($matches[2]) {
			case 'bai-hat':
				$pattern = '<iframe scrolling="no" width="640" height="180" src="http://mp3.zing.vn/embed/song/%1$s" frameborder="0" allowfullscreen="true"></iframe>';
				break;
			case 'video-clip':
				$pattern = '<iframe scrolling="no" width="853" height="520" src="http://mp3.zing.vn/embed/video/%1$s" frameborder="0" allowfullscreen="true"></iframe>';
				break;
			case 'album':
			case 'playlist':
				$pattern = '<iframe scrolling="no" width="853" height="390" src="http://mp3.zing.vn/embed/playlist/%1$s" frameborder="0" allowfullscreen="true"></iframe>';
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
